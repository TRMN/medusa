<?php

namespace Medusa\Echelons;

trait MedusaEchelons
{

    /**
     * Display a listing of the resource.
     * GET /echelon
     *
     * @return Response
     */
    public function index()
    {
        $chapters = \Chapter::orderBy('chapter_type')->orderBy('chapter_name')->get();

        return \View::make('chapter.index', ['chapters' => $chapters]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /echelon/create
     *
     * @return Response
     */
    public function create()
    {
        if ($redirect = $this->checkPermissions($this->permissions['ADD']) !== true) {
            return $redirect;
        }

        $types =
            \Type::whereIn('chapter_type', $this->chapterTypes)
                 ->orderBy('chapter_description')
                 ->get(
                     ['chapter_type', 'chapter_description']
                 );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        $chapterTypes = ['0' => $this->select] + $chapterTypes;

        return \View::make(
            'unit.create',
            [
                'chapterTypes' => $chapterTypes,
                'chapter'      => new \Chapter,
                'commands'     => ['0' => 'Select a Command/Unit'] + $this->getCommands(),
                'title'        => $this->title,
                'route'        => $this->routePrefix,
                'branches'     => $this->getBranches(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /echelon
     *
     * @return Response
     */
    public function store()
    {
        if ($redirect = $this->checkPermissions($this->permissions['ADD']) !== true) {
            return $redirect;
        }

        $validator = \Validator::make($data = \Input::all(), \Chapter::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === true) {
                unset($data[$k]);
            }
        }

        if (empty($data['joinable']) === true) {
            $data['joinable'] = false;
        }

        $this->writeAuditTrail(
            (string)\Auth::user()->_id,
            'create',
            'chapters',
            null,
            json_encode($data),
            $this->auditName . '@store'
        );

        \Chapter::create($data);

        return \Redirect::route('chapter.index');
    }

    /**
     * Display the specified resource.
     * GET /echelon/{id}
     *
     * @param  int $chapter
     *
     * @return Response
     */
    public function show(\Chapter $chapter)
    {
        if (isset($chapter->assigned_to)) {
            $parentChapter = \Chapter::find($chapter->assigned_to);
        } else {
            $parentChapter = false;
        }

        $includes = \Chapter::where('assigned_to', '=', $chapter->_id)->orderBy('chapter_name')->get()->toArray();

        $commandCrew = $chapter->getCommandCrew();

        $crew = $chapter->getCrew();

        return \View::make(
            'chapter.show',
            [
                'detail'   => $chapter,
                'higher'   => $parentChapter,
                'includes' => $includes,
                'command'  => $commandCrew,
                'crew'     => $crew
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     * GET /echelon/{id}/edit
     *
     * @param  int $chapter
     *
     * @return Response
     */
    public function edit(\Chapter $chapter)
    {
        if ($redirect = $this->checkPermissions($this->permissions['EDIT']) !== true) {
            return $redirect;
        }

        $types =
            \Type::whereIn('chapter_type', $this->chapterTypes)
                 ->orderBy('chapter_description')
                 ->get(
                     ['chapter_type', 'chapter_description']
                 );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => $this->select] + $chapterTypes;

        $crew = \User::where('assignment.chapter_id', '=', (string)$chapter->_id)->get();

        $childUnits = \Chapter::where('assigned_to', '=', (string)$chapter->_id)->get();

        return \View::make(
            'unit.edit',
            [
                'chapterTypes' => $chapterTypes,
                'chapter'      => $chapter,
                'chapterList'  => ['0' => 'Select a Command/Unit'] + $this->getCommands(),
                'numCrew'      => count($crew) + count($childUnits),
                'title'        => $this->title,
                'route'        => $this->routePrefix,
                'branches'     => $this->getBranches(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     * PUT /echelon/{id}
     *
     * @param  int $chapter
     *
     * @return Response
     */
    public function update(\Chapter $chapter)
    {
        if ($redirect = $this->checkPermissions($this->permissions['EDIT']) !== true) {
            return $redirect;
        }

        $validator = \Validator::make($data = \Input::all(), \Chapter::$updateRules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        unset($data['_method'], $data['_token']);

        if (empty($data['decommission_date']) === false &&
            empty($data['commission_date']) === false
        ) {
            // Figure out if the ship is in commission or not

            if (strtotime($data['commission_date']) > strtotime($data['decommission_date'])) {
                // Commission date is newer than decommission date
                unset($data['decommission_date']);
                $chapter->decommission_date = null;
            } else {
                // Decommission date is newer
                unset($data['commission_date']);
                $chapter->commission_date = null;
            }
        }

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === false) {
                $chapter->$k = $v;
            }
        }

        if (empty($data['joinable']) === true) {
            $chapter->joinable = false;
        }

        $this->writeAuditTrail(
            (string)\Auth::user()->_id,
            'update',
            'chapters',
            (string)$chapter->_id,
            $chapter->toJson(),
            $this->auditName . '@update'
        );

        $chapter->save();
        ;

        \Cache::flush();

        return \Redirect::route('chapter.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /echelon/{id}
     *
     * @param  int $chapter
     *
     * @return Response
     */
    public function destroy(\Chapter $chapter)
    {
        if ($redirect = $this->checkPermissions($this->permissions['DELETE']) !== true) {
            return $redirect;
        }

        $chapter->commission_date = '';
        $chapter->decommission_date = date('Y-m-d');

        $this->writeAuditTrail(
            (string)\Auth::user()->_id,
            'update',
            'chapters',
            (string)$chapter->_id,
            $chapter->toJson(),
            $this->auditName . '@destroy'
        );

        $chapter->save();

        return \Redirect::route('chapter.index');
    }

    public function deactivate(\Chapter $chapter)
    {
        if ($redirect = $this->checkPermissions($this->permissions['DELETE']) !== true) {
            return $redirect;
        }

        $crew = \User::where('assignment.chapter_id', '=', (string)$chapter->_id)->get();

        $childUnits = \Chapter::where('assigned_to', '=', (string)$chapter->_id)->get();

        return \View::make(
            'unit.confirm-deactivate',
            ['chapter' => $chapter, 'numCrew' => count($crew) + count($childUnits), 'title' => $this->title,]
        );
    }
}
