<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Chapter;
use App\MedusaConfig;
use App\Permissions\MedusaPermissions;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use League\Csv\Writer;

class ChapterController extends Controller
{
    use MedusaPermissions;

    /**
     * Get sorted and filtered slice of roster via ajax.
     *
     * @param \App\Chapter             $chapter
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChapterMembers(Chapter $chapter, Request $request)
    {
        // These checks are used multiple times, shove the results into variables
        $isInChainOfCommand = Auth::user()->isInChainOfCommand($chapter->getChapterIdWithParents());
        $viewMembers = Auth::user()->hasPermissions(['VIEW_MEMBERS']);

        // Sort order
        $order = $request->input('order');

        // Base query
        $query = User::where('active', 1)
                     ->where('registration_status', 'Active')
                     ->where('assignment.chapter_id', '=', $chapter->id);

        $totalRecords = $filteredRecords = $query->count();

        // Search term, if any

        $search = $request->input('search');

        if (empty($search['value']) === false) {
            // Have search term, filter the results
            $searchTerm = '%'.$search['value'].'%';

            $query = $query->where(
                function ($query) use ($searchTerm) {
                    $query->where('last_name', 'like', $searchTerm)
                          ->orWhere('first_name', 'like', $searchTerm)
                          ->orWhere('rank.grade', 'like', $searchTerm)
                          ->orWhere('member_id', 'like', $searchTerm)
                          ->orWhere('path', 'like', $searchTerm)
                          ->orWhere('branch', 'like', $searchTerm)
                          ->orWhere('city', 'like', $searchTerm)
                          ->orWhere('state_province', 'like', $searchTerm)
                          ->orWhere('assignment.billet', 'like', $searchTerm);
                }
            );

            // Updated the filtered records count
            $filteredRecords = $query->count();
        }

        // What column to sort by
        $sortOrder = $order[0]['dir'];

        // Different columns depending on permissions
        if ($isInChainOfCommand === true || $viewMembers === true) {
            switch ($order[0]['column']) {
                case 0:
                    $query = $query->orderBy('promotionStatus', $sortOrder);
                    break;
                case 1:
                    $query = $query->orderBy('last_name', $sortOrder)->orderBy('first_name', $sortOrder);
                    break;
                case 2:
                    $query = $query->orderBy('member_id', $sortOrder);
                    break;
                case 3:
                    $query = $query->orderBy('path', $sortOrder);
                    break;
                case 6:
                    $query = $query->orderBy('rank.grade', $sortOrder);
                    break;
                case 9:
                    $query = $query->orderBy('branch', $sortOrder);
                    break;
                case 10:
                    $query = $query->orderBy('city', $sortOrder);
                    break;
                case 11:
                    $query = $query->orderBy('state_province', $sortOrder);
                    break;
            }
        } else {
            switch ($order[0]['column']) {
                case 0:
                    $query = $query->orderBy('last_name', $sortOrder)->orderBy('first_name', $sortOrder);
                    break;
                case 1:
                    $query = $query->orderBy('rank.grade', $sortOrder);
                    break;
                case 4:
                    $query = $query->orderBy('branch', $sortOrder);
                    break;
            }
        }

        // Take the slice requested
        $users = $query->skip(intval($request->input('start')))->take(intval($request->input('length')))->get();

        $ret['draw'] = intval($request->draw);
        $ret['recordsTotal'] = $totalRecords;
        $ret['recordsFiltered'] = $filteredRecords;
        $ret['data'] = [];

        /*
         * Process the results.
         *
         * @var User
         */
        foreach ($users as $user) {
            if ($isInChainOfCommand === true || $viewMembers === true) {
                $highestExams = '';
                foreach ($user->getHighestExams() as $class => $exam) {
                    $highestExams .= $class.': '.$exam.'<br />';
                }

                $name = '<a href="/user/'.$user->id.'"'.
                        (is_null($user->promotionStatus) === true ? '' : ' class="promotable"').
                        '>'.$user->getFullName(true).'</a>';

                $ret['data'][] = [
                    '<span class="promotable">'.$user->promotionStatus.'</span>',
                    $name,
                    $user->member_id,
                    $user->path ? ucfirst($user->path) : 'Service',
                    number_format((float) $user->getTotalPromotionPoints(), 2),
                    $highestExams,
                    $user->rank['grade'].'<br />'.$user->getGreeting(),
                    is_null($tig = $user->getTimeInGrade(true)) ? 'N/A' : $tig,
                    $user->getBilletForChapter($chapter->id),
                    $user->branch.
                    (($user->branch == 'RMMM' || $user->branch == 'CIVIL') &&
                    empty($user->rating) === false ?
                        ' <span class="volkhov">( '.substr($user->getRate(), 0, 1).
                        ' )</span>' : ''),
                    $user->city,
                    $user->state_province,
                ];
            } else {
                $ret['data'][] = [
                  $user->getFullName(true),
                  $user->rank['grade'].'<br />'.$user->getGreeting(),
                  is_null($tig = $user->getTimeInGrade(true)) ? 'N/A' : $tig,
                  $user->getBilletForChapter($chapter->id),
                  $user->branch,
                ];
            }
        }

        return \response()->json($ret);
    }

    /**
     * Show the list of chapters.
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        $chapters =
            Chapter::orderBy('chapter_type')->orderBy('chapter_name')->get();

        return view('chapter.index', ['chapters' => $chapters]);
    }

    /**
     * Show a particular chapter.
     *
     * @param \App\Chapter $chapter
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Chapter $chapter)
    {
        if (($redirect = $this->loginValid()) !== true) {
            return $redirect;
        }

        if (isset($chapter->assigned_to)) {
            $parentChapter = Chapter::find($chapter->assigned_to);
        } else {
            $parentChapter = false;
        }

        $includes =
            Chapter::where('assigned_to', '=', $chapter->_id)
                   ->whereNull('decommission_date')
                   ->orderBy('chapter_name')
                   ->get();

        $commandCrew = $chapter->getCommandCrew();

        return view(
            'chapter.show',
            [
                'detail'   => $chapter,
                'higher'   => $parentChapter,
                'includes' => $includes,
                'command'  => $commandCrew,
            ]
        );
    }

    /**
     * Show the form for creating a new chapter.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('COMMISSION_SHIP')) !== true) {
            return $redirect;
        }

        $types =
            Type::whereIn(
                'chapter_type',
                Medusaconfig('chapter.types', ['ship', 'station'])
            )
                ->orderBy('chapter_description')
                ->get(
                    ['chapter_type', 'chapter_description']
                );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] =
                $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select a Ship Type'] + $chapterTypes;

        $chapters = Chapter::getChaptersByType('fleet');

        asort($chapters);

        return view(
            'chapter.create',
            [
                'chapterTypes' => $chapterTypes,
                'chapter'      => new Chapter(),
                'branches'     => Branch::getNavalBranchList(),
                'fleets'       => ['' => 'Select a Fleet'] + $chapters,
            ]
        );
    }

    /**
     * Edit a Chapters record.
     *
     * @param \App\Chapter $chapter
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('EDIT_SHIP')) !== true) {
            return $redirect;
        }

        $types =
            Type::whereIn('chapter_type', ['ship', 'station', 'small_craft', 'lac'])
                ->orderBy('chapter_description')
                ->get(
                    ['chapter_type', 'chapter_description']
                );
        $chapterTypes = [];

        foreach ($types as $chapterType) {
            $chapterTypes[$chapterType->chapter_type] =
                $chapterType->chapter_description;
        }

        $chapterTypes = ['' => 'Select a Ship Type'] + $chapterTypes;

        $chapters = array_merge(
            Chapter::getChaptersByType('ship'),
            Chapter::getChaptersByType('fleet'),
            Chapter::getChaptersByType('task_force'),
            Chapter::getChaptersByType('task_group'),
            Chapter::getChaptersByType('squadron'),
            Chapter::getChaptersByType('division')
        );

        asort($chapters);

        $crew =
            User::where('assignment.chapter_id', '=', (string) $chapter->_id)
                ->get();

        return view(
            'chapter.edit',
            [
                'chapterTypes' => $chapterTypes,
                'chapter'      => $chapter,
                'chapterList'  => $chapters,
                'branches'     => Branch::getNavalBranchList(),
                'numCrew'      => count($crew),
            ]
        );
    }

    /**
     * Process an update to a chapter.
     *
     * @param \App\Chapter $chapter
     *
     * @return $this|bool|\Illuminate\Http\RedirectResponse
     */
    public function update(Chapter $chapter, Request $request)
    {
        if (($redirect = $this->checkPermissions('EDIT_SHIP')) !== true) {
            return $redirect;
        }

        $this->validate($request, Chapter::$updateRules);

        $data = $request->all();

        unset($data['_method'], $data['_token']);

        if (empty($data['decommission_date']) === false &&
            empty($data['commission_date']) === false
        ) {
            // Figure out if the ship is in commission or not

            if (strtotime($data['commission_date']) >
                strtotime($data['decommission_date'])) {
                // Commission date is newer than decommission date
                unset($data['decommission_date']);
                $chapter->unset('decommission_date');
            } else {
                // Decommission date is newer
                unset($data['commission_date']);
                $chapter->unset('commission_date');
            }
        }

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === false) {
                $chapter->$k = $v;
            }
        }

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'update',
            'chapters',
            (string) $chapter->_id,
            $chapter->toJson(),
            'ChapterController@update'
        );

        $chapter->save();

        Cache::flush();

        return Redirect::route('chapter.index');
    }

    /**
     * Save a newly created chapter.
     *
     * @return Responsedb.
     */
    public function store(Request $request)
    {
        if (($redirect = $this->checkPermissions('COMMISSION_SHIP')) !== true) {
            return $redirect;
        }

        $this->validate($request, Chapter::$rules);

        $data = $request->all();

        foreach ($data as $k => $v) {
            if (empty($data[$k]) === true) {
                unset($data[$k]);
            }
        }

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'create',
            'chapters',
            null,
            json_encode($data),
            'ChapterController@store'
        );

        Chapter::create($data);

        return Redirect::route('chapter.index');
    }

    /**
     * Decommission a chapter.
     *
     * @param \App\Chapter $chapter
     *
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function decommission(Chapter $chapter)
    {
        if (($redirect =
                $this->checkPermissions('DECOMMISSION_SHIP')) !== true
        ) {
            return $redirect;
        }

        $crew = $chapter->getActiveCrewCount();

        return view(
            'chapter.confirm-decommission',
            ['chapter' => $chapter, 'numCrew' => $crew]
        );
    }

    /**
     * Remove the specified Chapter.
     *
     * @param  $chapterID
     *
     * @return Response
     */
    public function destroy(Chapter $chapter)
    {
        if (($redirect =
                $this->checkPermissions('DECOMMISSION_SHIP')) !== true
        ) {
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
            'ChapterController@destroy'
        );

        $chapter->save();

        return Redirect::route('chapter.index');
    }

    /**
     * Create a list of the command triads.
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function commandTriadReport()
    {
        if (($redirect = $this->checkPermissions('TRIAD_REPORT')) !== true) {
            return $redirect;
        }

        //get list of ships and stations
        $results =
            Chapter::where('chapter_type', '=', 'ship')
                   ->orWhere('chapter_type', '=', 'station')
                   ->get();

        $output[] =
            "'Member Number','Fleet','Name','Rank','Date of Rank','Billet','Ship','Highest Exam','Exam Date'\n";
        foreach ($results as $chapter) {
            $commandTriad = $chapter->getCommandCrew();

            foreach ($commandTriad as $billetInfo) {
                if (is_object($billetInfo['user']) &&
                    get_class($billetInfo['user']) == \App\User::class) {
                    $user = $billetInfo['user'];
                    switch (substr($user->rank['grade'], 0, 1)) {
                        case 'E':
                            $exam = $user->getHighestEnlistedExam();
                            break;
                        case 'W':
                            $exam = $user->getHighestWarrantExam();
                            break;
                        case 'O':
                        case 'F':
                            $exam = $user->getHighestOfficerExam();
                            break;
                        default:
                            $exam = [];
                    }

                    if (count($exam) > 0) {
                        $examID = key($exam);
                        $examInfo = "$examID,{$exam[$examID]['date']}";
                    } else {
                        $examInfo = ',';
                    }

                    $output[] =
                        "{$user->member_id},{$chapter->getAssignedFleet()},{$user->getFullName()},{$user->rank['grade']},{$user->rank['date_of_rank']},{$billetInfo['display']},$chapter->chapter_name,$examInfo\n";
                }
            }
        }

        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: '.gmdate('D, d M Y H:i:s'));
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="triad_report.csv"');
        header('Content-Transfer-Encoding: base64');
        header('Connection: close');
        foreach ($output as $line) {
            echo $line;
        }
        exit();
    }

    /**
     * Export a chapters roster.
     *
     * @param \App\Chapter $chapter
     *
     * @throws \League\Csv\CannotInsertRecord
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function exportRoster(Chapter $chapter)
    {
        if (($redirect = $this->checkPermissions('DUTY_ROSTER')) !== true) {
            return $redirect;
        }

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setNewline("\r\n");
        $crew = $chapter->getAllCrew();

        $headers =
            [
                'RMN Number',
                'First Name',
                'Middle Name',
                'Last Name',
                'Suffix',
                'Email Address',
                'Phone Number',
                'Address 1',
                'Address 2',
                'City',
                'State/Province',
                'Postal Code',
                'Country',
                'Rank',
                'Date of Rank',
                'Branch',
                'Billet',
            ];

        $csv->insertOne($headers);

        foreach ($crew as $member) {
            $csv->insertOne(
                [
                    $member->member_id,
                    $member->first_name,
                    $member->middle_name,
                    $member->last_name,
                    $member->suffix,
                    $member->email_address,
                    $member->phone_number,
                    $member->address1,
                    $member->address2,
                    $member->city,
                    $member->state_province,
                    $member->postal_code,
                    $member->country,
                    $member->rank['grade'],
                    $member->rank['date_of_rank'],
                    $member->branch,
                    $member->getBillet('primary'),
                ]
            );
        }

        $csv->output(
            date('Y-m-d').'_'.str_replace(
                ' ',
                '_',
                $chapter->chapter_name
            ).'_roster.csv'
        );
    }
}
