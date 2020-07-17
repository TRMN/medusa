<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Chapter;
use App\Type;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class EchelonController.
 */
class EchelonController extends Controller
{
    private $chapterTypes = ['district', 'fleet', 'task_force', 'task_group', 'squadron', 'division'];
    private $permissions = ['ADD' => 'CREATE_ECHELON', 'EDIT' => 'CREATE_ECHELON', 'DELETE' => 'DEL_ECHELON'];
    private $auditName = 'EchelonController';
    private $select = 'Select an Echelon Type';
    private $title = 'an Echelon';
    private $branch = 'RMN';

    /**
     * Display a listing of the resource.
     * GET /echelon.
     *
     * @return Response
     */
    public function index()
    {
        $chapters = Chapter::orderBy('chapter_type')->orderBy('chapter_name')->get();

        return view('chapter.index', ['chapters' => $chapters]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /echelon/create.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('CREATE_ECHELON')) !== true) {
            return $redirect;
        }

        $types =
            Type::whereIn('chapter_type', ['district', 'fleet', 'task_force', 'task_group', 'squadron', 'division'])->orderBy('chapter_description')->get(
                ['chapter_type', 'chapter_description']
            );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select an Echelon Type'] + $chapterTypes;

        $chapters = array_merge(
            Chapter::getChaptersByType('district'),
            Chapter::getChaptersByType('fleet'),
            Chapter::getChaptersByType('task_force'),
            Chapter::getChaptersByType('task_group'),
            Chapter::getChaptersByType('squadron'),
            Chapter::getChaptersByType('division')
        );

        asort($chapters);

        return view(
            'echelon.create',
            [
                'chapterTypes' => $chapterTypes,
                'chapter' => new Chapter(),
                'branches' => Branch::getNavalBranchList(),
                'fleets' => ['' => 'Select an Echelon'] + $chapters,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /echelon.
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->checkPermissions('CREATE_ECHELON')) !== true) {
            return $redirect;
        }

        $validator = Validator::make($data = Request::all(), Chapter::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === true) {
                unset($data[$k]);
            }
        }

        $data['joinable'] = false;

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'create',
            'chapters',
            null,
            json_encode($data),
            'EchelonController@store'
        );

        Chapter::create($data);

        return Redirect::route('chapter.index');
    }

    /**
     * Display the specified resource.
     * GET /echelon/{id}.
     *
     * @param int $chapter
     *
     * @return Response
     */
    public function show(Chapter $chapter)
    {
        if (isset($chapter->assigned_to)) {
            $parentChapter = Chapter::find($chapter->assigned_to);
        } else {
            $parentChapter = false;
        }

        $includes = Chapter::where('assigned_to', '=', $chapter->_id)->orderBy('chapter_name')->get()->toArray();

        $commandCrew = $chapter->getCommandCrew();

        $crew = $chapter->getCrew();

        return view(
            'chapter.show',
            [
                'detail' => $chapter,
                'higher' => $parentChapter,
                'includes' => $includes,
                'command' => $commandCrew,
                'crew' => $crew,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     * GET /echelon/{id}/edit.
     *
     * @param int $chapter
     *
     * @return Response
     */
    public function edit(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('EDIT_ECHELON')) !== true) {
            return $redirect;
        }

        $types =
            Type::whereIn('chapter_type', ['district', 'fleet', 'task_force', 'task_group', 'squadron', 'division'])
                ->orderBy('chapter_description')
                ->get(
                    ['chapter_type', 'chapter_description']
                );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] = $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select an Echelon Type'] + $chapterTypes;

        $chapters = array_merge(
            Chapter::getChaptersByType('district'),
            Chapter::getChaptersByType('fleet'),
            Chapter::getChaptersByType('task_force'),
            Chapter::getChaptersByType('task_group'),
            Chapter::getChaptersByType('squadron'),
            Chapter::getChaptersByType('division')
        );

        asort($chapters);

        $crew = User::where('assignment.chapter_id', '=', (string) $chapter->_id)->get();

        $childUnits = Chapter::where('assigned_to', '=', (string) $chapter->_id)->get();

        return view(
            'echelon.edit',
            [
                'chapterTypes' => $chapterTypes,
                'chapter' => $chapter,
                'chapterList' => $chapters,
                'branches' => Branch::getNavalBranchList(),
                'numCrew' => count($crew) + count($childUnits),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     * PUT /echelon/{id}.
     *
     * @param int $chapter
     *
     * @return Response
     */
    public function update(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('EDIT_ECHELON')) !== true) {
            return $redirect;
        }

        $validator = Validator::make($data = Request::all(), Chapter::$updateRules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        unset($data['_method'], $data['_token']);

        if (empty($data['decommission_date']) === false &&
            empty($data['commission_date']) === false
        ) {
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

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === false) {
                $chapter->$k = $v;
            }
        }

        $chapter->joinable = false;

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'update',
            'chapters',
            (string) $chapter->_id,
            $chapter->toJson(),
            'EchelonController@update'
        );

        $chapter->save();

        Cache::flush();

        return Redirect::route('chapter.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /echelon/{id}.
     *
     * @param int $chapter
     *
     * @return Response
     */
    public function destroy(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('DEL_ECHELON')) !== true) {
            return $redirect;
        }

        $chapter->commission_date = '';
        $chapter->decommission_date = date('Y-m-d');

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'update',
            'chapters',
            (string) $chapter->_id,
            $chapter->toJson(),
            'EchelonController@update'
        );

        $chapter->save();

        return Redirect::route('chapter.index');
    }

    public function deactivate(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('DEL_ECHELON')) !== true) {
            return $redirect;
        }

        $crew = $chapter->getActiveCrewCount();

        $childUnits = count($chapter->getChapterIdWithChildren()) - 1;

        return view('echelon.confirm-deactivate', ['chapter' => $chapter, 'numCrew' => $crew + $childUnits]);
    }
}
