<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Chapter;
use App\Models\MedusaConfig;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $validTypes = MedusaConfig::get('report.valid_types', ['ship', 'station', 'small_craft', 'lac']);
        $chapter = Chapter::find(Auth::user()->getAssignedShip());

        if ($this->hasDutyRosterForAssignedShip() === false ||
            in_array($chapter->chapter_type, $validTypes) === false) {
            return redirect(URL::previous())
                ->with('message', 'None of your assignments are required to report or able to use this feature');
        }

        return view(
            'report.index',
            [
            'reports' => Report::where('chapter_id', '=', $chapter->id)->orderBy('report_date')->get(),
            'chapterName' => $chapter->chapter_name,
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
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $validTypes = MedusaConfig::get('report.valid_types', ['ship', 'station', 'small_craft', 'lac']);

        foreach ([
                   'primary',
                   'secondary',
                   'additional',
                   'extra',
                 ] as $assignment) {
            $chapter =
              Chapter::find(Auth::user()->getAssignmentId($assignment));

            if (empty($chapter->chapter_type) === false && in_array($chapter->chapter_type, $validTypes) === true) {
                break;
            }
        }

        if ((is_null($chapter) === false && in_array($chapter->chapter_type, $validTypes) === false) ||
            is_null($chapter) === true) {
            return redirect(URL::previous())->with(
                'message',
                'I was unable to find an appropriate command for this report.'
            );
        }

        $first = strtotime(date('Y').'-'.date('m').'-01');

        if (date('n') & 1 == 1) {
            $ts = strtotime('-1 month', $first);
            $month =
              date('F, Y', strtotime(date('Y').'-'.(date('n') + 1).'-01'));
        } else {
            $ts = strtotime('-2 month', $first);
            $month = date('F, Y');
        }

        // Check and make sure that there's no pending requests

        $reportDate = date('n') & 1 ? date('Y-m', strtotime(date('Y').'-'.(date('n') + 1).'-01')) : date('Y-m');

        $report = $this->doesReportExists($chapter, $reportDate);

        if (is_a($report, 'Illuminate\Http\Response')) {
            return $report;
        }

        if (isset($report) === true && empty($report->report_sent) === false) {
            // The current report has been sent and they want to start the next one
            $month =
              date('F, Y', strtotime('+2 months', strtotime($report->report_date)));
            $ts = strtotime('-2 months', strtotime($month));

            // Just in case this is not the first time they've done this
            $report = $this->doesReportExists($chapter, date('Y-m', strtotime($month)));

            if (is_a($report, 'Illuminate\Http\Response')) {
                return $report;
            }

            // If for some reason this report has already been sent, send them back to the index page with a message.

            if (empty($report->report_sent) === false) {
                return Response::redirectToRoute('report.index')->with('error', 'It is too soon to create a new report');
            }
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

    private function doesReportExists(Chapter $chapter, $reportDate)
    {
        $report =
            Report::where(
                'chapter_id',
                '=',
                $chapter->id
            )->where(
                'report_date',
                '=',
                $reportDate
            )->first();

        if (isset($report) === true && empty($report->report_sent) === true) {
            return Response::view('report.chapter-edit', ['report' => $report]);
        }

        return $report;
    }

    public function getCompletedExamsForCrew($id, $ts = null)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $chapter = Chapter::find($id);

        if (is_null($ts) === true) {
            if (date('n') & 1 == 1) {
                $ts =
                  strtotime(
                      '-1 month',
                      strtotime(date('Y').'-'.date('m').'-01')
                  );
            } else {
                $ts =
                  strtotime(
                      '-2 month',
                      strtotime(date('Y').'-'.date('m').'-01')
                  );
            }
        }

        $crewList = $chapter->getAllCrew($id);

        $examsCompleted = '';

        foreach ($crewList as $member) {
            $completed = $member->getCompletedExams(date('Y-m-d', $ts));

            if (empty($completed) === false) {
                $examsCompleted .= $member->first_name.' '.$member->last_name.' ('.$member->member_id.') '.$completed.'; ';
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
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $data = Request::all();
        $chapter = Chapter::findOrFail($data['chapter_id']);
        $commandCrew = $chapter->getCommandCrew();

        foreach ($commandCrew as $billetInfo) {
            $member = $billetInfo['user'];

            $member->last_course = $member->getHighestMainLineExamForBranch();
            $data['command_crew'][$billetInfo['display']] =
              Arr::only(
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
                  'rank',
                  ]
              );
        }

        $data['chapter_info'] = $chapter->toArray();

        $ts = strtotime('-2 months', strtotime($data['report_date']));

        $newCrew = $chapter->getCrew(true, $ts);

        foreach ($newCrew as $crew) {
            $data['new_crew'][] =
              Arr::only($crew, [
                'first_name',
                'last_name',
                'middle_name',
                'suffix',
                'member_id',
                'branch',
                'rank',
              ]);
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

        if (empty($data['send_report']) === false) {
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
                date('F, Y', strtotime($report->report_date)).' Report Sent'
            );
        }

        return Response::redirectToRoute('report.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $report = Report::find($id);

        $commandCrew = $report['command_crew'];

        if (empty($commandCrew['CO']) === false) {
            $commandCrew['Commanding Officer'] = $commandCrew['CO'];
            $commandCrew['Executive Officer'] = $commandCrew['XO'];
            $commandCrew['Bosun'] = $commandCrew['BOSUN'];

            $report['command_crew'] = $commandCrew;
        }

        return Response::view('report.chapter-show', ['report' => $report]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $this->updateNewCrew($id);

        $report = Report::find($id);

        if (empty($report['report_sent']) === false) {
            return redirect(URL::previous())->with(
                'message',
                'You may not edit a report that has already been sent'
            );
        }

        $commandCrew = $report['command_crew'];

        if (empty($commandCrew['CO']) === false) {
            $commandCrew['Commanding Officer'] = $commandCrew['CO'];
            $commandCrew['Executive Officer'] = $commandCrew['XO'];
            $commandCrew['Bosun'] = $commandCrew['BOSUN'];

            $report['command_crew'] = $commandCrew;
        }

        return Response::view('report.chapter-edit', ['report' => $report]);
    }

    private function updateNewCrew($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
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
              Arr::only($crew, [
                'first_name',
                'last_name',
                'middle_name',
                'suffix',
                'member_id',
                'branch',
                'rank',
              ]);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        $report = Report::find($id);

        $data = Request::all();

        $msg = date('F, Y', strtotime($report->report_date)).' Report Saved';

        foreach ($data as $key => $value) {
            $report->$key = $value;
        }

        $report->save();

        if (empty($data['send_report']) === false) {
            // email the report
            $this->emailReport($report->id);

            $report->report_sent = date('Y-m-d');

            $msg =
              date('F, Y', strtotime($report->report_date)).' Report Sent';
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
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (empty(Session::get('orig_user')) === true) {
            return redirect(URL::previous())->with('message', 'You do not have permission to view that page');
        }

        $report = Report::find($id);

        $report->delete();

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'delete',
            'reports',
            (string) $report->_id,
            $report->toJson(),
            'ReportController@destroy'
        );

        return Redirect::route('report.index');
    }

    public function sendReport($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
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
            date('F, Y', strtotime($report->report_date)).' Report Sent'
        );
    }

    public function emailReport($id)
    {
        if (($redirect = $this->checkPermissions('CHAPTER_REPORT')) !== true) {
            return $redirect;
        }

        // Get the report
        $report = Report::find($id);
        $chapter = Chapter::find($report->chapter_id);

        $commandCrew = $report['command_crew'];

        if (empty($commandCrew['CO']) === false) {
            $commandCrew['Commanding Officer'] = $commandCrew['CO'];
            $commandCrew['Executive Officer'] = $commandCrew['XO'];
            $commandCrew['Bosun'] = $commandCrew['BOSUN'];

            $report['command_crew'] = $commandCrew;
        }

        $echelonEmails = [];

        foreach ($chapter->getChapterIdWithParents() as $chapterId) {
            $tmpChapter = Chapter::find($chapterId);

            if (in_array(
                $tmpChapter->chapter_type,
                [
                  'ship',
                  'division',
                  'squadron',
                  'task_group',
                  'task_force',
                  'fleet',
                  'station',
                ]
            ) === true
            ) {
                if ($chapter->id != $tmpChapter->id) {
                    if (empty($tmpChapter->getCO()) === false) {
                        $echelonEmails[] = $tmpChapter->getCO()->email_address;
                    }

                    if ($tmpChapter->chapter_type === 'fleet') {
                        if (is_object($xo = $tmpChapter->getXO())) {
                            $echelonEmails[] = $xo->email_address;
                        }
                    }
                }
            }
        }

        Mail::send(
            'report.chapter-email',
            [
            'report' => $report,
            ],
            function ($message) use ($report, $echelonEmails) {
                $message->from(
                    'bucomm@trmn.org',
                    'On behalf of CO, '.$report['chapter_info']['chapter_name']
                );

                $message->to($report->command_crew['Commanding Officer']['email_address']);

                $additionalRecipients = MedusaConfig::get(
                    'report.recipients',
                    ['cno@trmn.org', 'buplan@trmn.org', 'buships@trmn.org', 'bupers@trmn.org']
                );

                foreach ($additionalRecipients as $recipient) {
                    $message->cc($recipient);
                }

                foreach ($echelonEmails as $echelon) {
                    $message->cc($echelon);
                }

                $message->subject(
                    date(
                        'F, Y',
                        strtotime($report->report_date)
                    ).' Chapter Report for '.$report['chapter_info']['chapter_name']
                );
            }
        );
    }
}
