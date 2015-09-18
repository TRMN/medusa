<?php

class ChapterController extends BaseController
{

    public function index()
    {
        $chapters = Chapter::orderBy( 'chapter_type' )->orderBy( 'chapter_name' )->get();

        return View::make( 'chapter.index', [ 'chapters' => $chapters ] );
    }

    public function show( $chapter )
    {
        if ( isset( $chapter->assigned_to ) ) {
            $parentChapter = Chapter::find( $chapter->assigned_to );
        } else {
            $parentChapter = false;
        }

        $includes = Chapter::where( 'assigned_to', '=', $chapter->_id )->whereNull('decommission_date')->orderBy('chapter_name')->get()->toArray();

        $commandCrew = $chapter->getCommandCrew();

        $crew = $chapter->getCrew();

        return View::make( 'chapter.show', [ 'detail' => $chapter, 'higher' => $parentChapter, 'includes' => $includes, 'command' => $commandCrew, 'crew' => $crew ] );
    }

    /**
     * Show the form for creating a new chapter
     *
     * @return Response
     */
    public function create()
    {
        $this->checkPermissions('COMMISSION_SHIP');

        $types = Type::whereIn('chapter_type', ['ship', 'station'])->orderBy('chapter_description')->get(['chapter_type', 'chapter_description']);
        $chapterTypes = [ ];

        foreach ( $types as $chapterType ) {
            $chapterTypes[ $chapterType->chapter_type ] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select a Ship Type'] + $chapterTypes;

        $chapters = Chapter::getChaptersByType('fleet');

        asort($chapters);

        return View::make('chapter.create', [
            'chapterTypes' => $chapterTypes,
            'chapter' => new Chapter,
            'branches' => Branch::getNavalBranchList(),
            'fleets' => ['' => 'Select a Fleet'] + $chapters,]
        );
    }

    public function edit(Chapter $chapter )
    {
        $this->checkPermissions('EDIT_SHIP');

        $types =
            Type::whereIn('chapter_type', ['ship', 'station'])->orderBy('chapter_description')->get(
                ['chapter_type', 'chapter_description']
            );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select a Ship Type'] + $chapterTypes;

        $chapters = array_merge(Chapter::getChaptersByType('fleet'),
            Chapter::getChaptersByType('task_force'),
            Chapter::getChaptersByType('task_group'),
            Chapter::getChaptersByType('squadron'),
            Chapter::getChaptersByType('division')
            );

        asort($chapters);

        $crew = User::where('assignment.chapter_id', '=', (string)$chapter->_id)->get();

        return View::make( 'chapter.edit', [ 'chapterTypes' => $chapterTypes, 'chapter' => $chapter, 'chapterList' => $chapters,
                                             'branches' => Branch::getNavalBranchList(), 'numCrew' => count($crew),
        ]);
    }

    public function update(Chapter $chapter )
    {
        $this->checkPermissions('EDIT_SHIP');

        $validator = Validator::make( $data = Input::all(), Chapter::$updateRules );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        unset( $data[ '_method' ], $data[ '_token' ] );

        if (empty($data['decommission_date']) === false &&
            empty($data['commission_date'])=== false) {
            // Figure out if the ship is in commission or not

            if (strtotime($data['commission_date']) > strtotime($data['decommission_date'])) {
                // Commission date is newer than decommission date
                unset($data['decommission_date']);
                $chapter->decommission_date = '';
            } else {
                // Decommission date is newer
                unset($data['commission_date']);
                $chapter->commission_date = '';
            }
        }

        foreach ( $data as $k => $v ) {
            if ( empty( $data[ $k ] ) === false ) {
                $chapter->$k = $v;
            }
        }

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'chapters',
            (string)$chapter->_id,
            $chapter->toJson(),
            'ChapterController@update'
        );

        $chapter->save();;

        Cache::flush();

        return Redirect::route( 'chapter.index' );
    }

    /**
     * Save a newly created chapter
     *
     * @return Responsedb.
     */
    public function store()
    {
        $this->checkPermissions('COMMISSION_SHIP');

        $validator = Validator::make( $data = Input::all(), Chapter::$rules );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        foreach ( $data as $k => $v ) {
            if ( empty( $data[ $k ] ) === true ) {
                unset( $data[ $k ] );
            }
        }

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'create',
            'chapters',
            null,
            json_encode($data),
            'ChapterController@store'
        );

        Chapter::create( $data );

        return Redirect::route( 'chapter.index' );
    }

    public function decommission(Chapter $chapter)
    {
        $this->checkPermissions('DECOMMISSION_SHIP');

        $crew = User::where('assignment.chapter_id', '=', (string)$chapter->_id)->get();

        return View::make('chapter.confirm-decommission', ['chapter' => $chapter, 'numCrew' => count($crew),]);
    }
    /**
     * Remove the specified Chapter.
     *
     * @param  $chapterID
     * @return Response
     */
    public function destroy(Chapter $chapter )
    {
        $this->checkPermissions('DECOMMISSION_SHIP');

        $chapter->commission_date = '';
        $chapter->decommission_date = date('Y-m-d');

        $this->writeAuditTrail(
            (string)Auth::user()->_id,
            'update',
            'chapters',
            (string)$chapter->_id,
            $chapter->toJson(),
            'ChapterController@destroy'
        );

        $chapter->save();

        return Redirect::route('chapter.index');

    }
}
