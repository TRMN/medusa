<?php

class ReportController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        return Response::view(
            'report.index',
            [
                'reports' => Report::where('chapter_id', '=', Auth::user()->getAssignedShip())->orderBy(
                    'report_date'
                )->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        foreach (['primary', 'secondary', 'additional'] as $assignment) {
            $chapter = Chapter::find(Auth::user()->getAssignmentId($assignment));

            if (empty($chapter->chapter_type) === false && ($chapter->chapter_type == 'ship' || $chapter->chapter_type == 'station')) {
                break;
            }
        }

        if (in_array($chapter->chapter_type, ['ship', 'station']) === false) {
            return \Redirect::to(\URL::previous())->with(
                'message',
                'I was unable to find an appropriate command for this report.'
            );
        }

        $first = strtotime(date('Y') . '-' . date('m') . '-01');

        if (date('n') & 1 == 1) {
            $ts = strtotime('-1 month', $first);
            $month = date('F, Y', strtotime(date('Y') . '-' . ( date('n') + 1 ) . '-01'));
        } else {
            $ts = strtotime('-2 month', $first);
            $month = date('F, Y');
        }

        // Check and make sure that there's no pending requests

        $reportDate = date('n') & 1 ?
            date('Y-m', strtotime(date('Y') . '-' . ( date('n') + 1 ) . '-01')) :
            date('Y-m');

        $report =
            Report::where('chapter_id', '=', Auth::user()->getPrimaryAssignmentId())->where(
                'report_date',
                '=',
                $reportDate
            )->first();

        if (count($report) === 1 && empty( $report->report_sent ) === true) {
            // report found, send them to the edit form
            return Response::view('report.chapter-edit', ['report' => $report]);
        } elseif (count($report) === 1 && empty( $report->report_sent ) === false) {
            // The current report has been sent and they want to start the next one
            $month = date('F, Y', strtotime('+2 months', strtotime($report->report_date)));
            $ts = strtotime('-2 months', strtotime($month));
        }

        $viewData = [
            'month'     => $month,
            'user'      => Auth::user(),
            'chapter'   => $chapter,
            'command'   => $chapter->getCommandCrew(),
            'newCrew'   => $chapter->getCrew(true, $ts),
            'completed' => $this->getCompletedExamsForCrew($chapter->id, $ts),
        ];

        return Response::view('report.chapter-create', $viewData);
    }

    public function getCompletedExamsForCrew($id, $ts = null)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $chapter = Chapter::find($id);

        if (is_null($ts) === true) {
            if (date('n') & 1 == 1) {
                $ts = strtotime('-1 month', strtotime(date('Y') . '-' . date('m') . '-01'));
            } else {
                $ts = strtotime('-2 month', strtotime(date('Y') . '-' . date('m') . '-01'));
            }
        }

        $crewList = $chapter->getAllCrew($id);

        $examsCompleted = '';

        foreach ($crewList as $member) {
            $completed = $member->getCompletedExams(date('Y-m-d', $ts));

            if (empty( $completed ) === false) {
                $examsCompleted .= $member->first_name . ' ' . $member->last_name . ' (' . $member->member_id . ') ' . $completed . '; ';
            }
        }

        return $examsCompleted;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $data = Input::all();
        $chapter = Chapter::findOrFail($data['chapter_id']);
        $commandCrew = $chapter->getCommandCrew();

        foreach ($commandCrew as $postion => $member) {
            $member->last_course = $member->getHighestMainLineExamForBranch();
            $data['command_crew'][$postion] =
                array_only(
                    $member->toArray(),
                    [
                        'branch',
                        'member_id',
                        'first_name',
                        'last_name',
                        'middle_name',
                        'suffix',
                        'last_course',
                        'email_address',
                        'dob',
                        'city',
                        'state_province',
                        'phone_number',
                        'rank'
                    ]
                );
        }

        $data['chapter_info'] = $chapter->toArray();

        $ts = strtotime('-2 months', strtotime($data['report_date']));

        $newCrew = $chapter->getCrew(true, $ts);

        foreach ($newCrew as $crew) {
            $data['new_crew'][] =
                array_only($crew, ['first_name', 'last_name', 'middle_name', 'suffix', 'member_id', 'branch', 'rank']);
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'create',
            'reports',
            null,
            json_encode($data),
            'ReportController@store'
        );

        $report = Report::create($data);

        if (empty( $data['send_report'] ) === false) {
            // email the report
            $this->emailReport($report->id);

            $report->report_sent = date('Y-m-d');

            $this->writeAuditTrail(
                Auth::user()->id,
                'update',
                'reports',
                $report->id,
                $report->toJson(),
                'ReportController@store'
            );

            $report->save();

            return Redirect::route('report.index')->with(
                'message',
                date('F, Y', strtotime($report->report_date)) . ' Report Sent'
            );
        }

        return Response::view(
            'report.index',
            [
                'reports' => Report::where('chapter_id', '=', Auth::user()->getPrimaryAssignmentId())->orderBy(
                    'report_date'
                )->get()
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        return Response::view('report.chapter-show', ['report' => Report::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $this->updateNewCrew($id);

        return Response::view('report.chapter-edit', ['report' => Report::find($id)]);
    }

    private function updateNewCrew($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $report = Report::find($id);

        // Every time the report is edited, update the new crew list

        $ts = strtotime('-2 months', strtotime($report->report_date));

        $chapter = Chapter::find($report->chapter_id);

        $newCrew = $chapter->getCrew(true, $ts);

        $new_crew = [];

        foreach ($newCrew as $crew) {
            $new_crew[] =
                array_only($crew, ['first_name', 'last_name', 'middle_name', 'suffix', 'member_id', 'branch', 'rank']);
        }

        $report->new_crew = $new_crew;

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'reports',
            null,
            $report->toJson(),
            'ReportController@edit'
        );

        $report->save();

        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $report = Report::find($id);

        $data = Input::all();

        $msg = date('F, Y', strtotime($report->report_date)) . ' Report Saved';

        foreach ($data as $key => $value) {
            $report->$key = $value;
        }

        if (empty( $data['send_report'] ) === false) {
            // email the report
            $this->emailReport($report->id);

            $report->report_sent = date('Y-m-d');

            $msg = date('F, Y', strtotime($report->report_date)) . ' Report Sent';
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'reports',
            $report->id,
            $report->toJson(),
            'ReportController@update'
        );

        $report->save();

        return Redirect::route('report.index')->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendReport($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        $this->updateNewCrew($id);

        // Get the report
        $report = Report::find($id);

        $this->emailReport($report->id);

        $report->report_sent = date('Y-m-d');

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'reports',
            $report->id,
            $report->toJson(),
            'ReportController@sendReport'
        );

        $report->save();

        return Redirect::route('report.index')->with(
            'message',
            date('F, Y', strtotime($report->report_date)) . ' Report Sent'
        );
    }

    public function emailReport($id)
    {
        if (( $redirect = $this->checkPermissions('CHAPTER_REPORT') ) !== true) {
            return $redirect;
        }

        // Get the report
        $report = Report::find($id);
        $chapter = Chapter::find($report->chapter_id);

        $echelonEmails = [];

        foreach ($chapter->getChapterIdWithParents() as $chapterId) {
            $tmpChapter = Chapter::find($chapterId);

            if (in_array(
                    $tmpChapter->chapter_type,
                    ['ship', 'division', 'squadron', 'task_group', 'task_force', 'fleet', 'station']
                ) === true
            ) {
                if ($chapter->id != $tmpChapter->id) {
                    if (empty($tmpChapter->getCO()) === false) {
                    $echelonEmails[] = $tmpChapter->getCO()->email_address;
                    }
                }
            }
        }

        Mail::send(
            'report.chapter-email',
            [
                'report' => $report
            ],
            function ($message) use ($report, $echelonEmails) {

                $message->from('bucomm@trmn.org',
                    'On behalf of CO, ' . $report['chapter_info']['chapter_name']
                );

                $message->to($report->command_crew['CO']['email_address']);

                $message->cc('cno@trmn.org')->cc('buplan@trmn.org')->cc('buships@trmn.org')->cc('bupers@trmn.org');

                foreach ($echelonEmails as $echelon) {
                    $message->cc($echelon);
                }

                $message->subject(
                    date(
                        'F, Y',
                        strtotime($report->report_date)
                    ) . ' Chapter Report for ' . $report['chapter_info']['chapter_name']
                );
            }
        );
    }

}
