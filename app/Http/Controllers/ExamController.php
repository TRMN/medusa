<?php

namespace App\Http\Controllers;

use App\Events\GradeEntered;
use App\Exam;
use App\ExamList;
use App\Message;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /exam.
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('UPLOAD_EXAMS')) !== true) {
            return $redirect;
        }

        return view(
            'exams.index',
            ['messages' => Message::where('source', '=', 'import_grades')->orderBy('created_at', 'asc')->get()]
        );
    }

    public function examList()
    {
        if (($redirect = $this->checkPermissions(['EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        return view('exams.list');
    }

    public function find($user = null, $message = null)
    {
        if (($redirect = $this->checkPermissions(['ADD_GRADE', 'EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        return view('exams.find', ['user' => $user, 'message' => $message]);
    }

    public function manageExamPerms($user = null)
    {
        if (($redirect = $this->checkPermissions(['EDIT_MEMBER', 'EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        return view('user.find', ['user' => $user]);
    }

    public function edit(ExamList $exam)
    {
        if (($redirect = $this->checkPermissions(['EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        return view('exams.edit', ['exam' => $exam]);
    }

    public function create()
    {
        if (($redirect = $this->checkPermissions(['EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        return view('exams.create');
    }

    public function updateExam()
    {
        if (($redirect = $this->checkPermissions(['EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        $data = Request::all();

        $exam = ExamList::find($data['id']);
        $exam->name = $data['name'];
        if (empty($data['enabled']) === true) {
            $exam->enabled = false;
        } else {
            $exam->enabled = true;
        }

        $exam->save();

        return view('exams.list');
    }

    public function update()
    {
        if (($redirect = $this->checkPermissions(['ADD_GRADE', 'EDIT_GRADE'])) !== true) {
            return $redirect;
        }

        unset($message);

        // Validation rules

        $rules = [
            'member_id' => 'required|size:11|not_self',
            'exam' => 'required|is_grader|exists:exam_list,exam_id',
            'date' => 'required|date|date_format:Y-m-d|post_dated',
            'score' => 'required|valid_grade',
        ];

        $errorMessages = [
            'member_id.required' => "The member's RMN number is required",
            'exam.required' => 'The Exam ID is required',
            'exam.exists' => 'You have entered an invalid exam id',
            'date.required' => 'You must provide the date the exam was graded',
            'date_format' => 'Dates must be formated Y-M-D',
        ];

        $data = Request::all();

        $validator = Validator::make($data, $rules, $errorMessages);

        if ($validator->fails()) {
            return redirect(URL::previous())->withErrors($validator)->withInput();
        }

        if (preg_match('/^\d*$/', trim($data['score'])) === 1) {
            $data['score'] = trim($data['score']).'%';
        } else {
            $data['score'] = strtoupper(trim($data['score']));
        }

        // Get the user's exam record

        $record = Exam::where('member_id', '=', $data['member_id'])->first();

        // Get the user record as well

        $member = User::where('member_id', '=', $data['member_id'])->first();

        // This might be an update, so check and see if the exam exists in the exams array

        if (empty($record->exams) === false && array_key_exists($data['exam'], $record->exams) === true) {
            // This is an edit, update it

            $exams = $record->exams;

            $exams[strtoupper($data['exam'])] = [
                'score' => $data['score'],
                'date' => $data['date'],
                'entered_by' => Auth::user()->id,
                'date_entered' => date('Y-m-d'),
            ];

            $record->exams = $exams;

            $message =
                '<span class="fi-alert alert">'.strtoupper($data['exam']).' updated in academy coursework for '.
                $member->first_name.' '.
                (! empty($member->middle_name) ? $member->middle_name.' ' : '').$member->last_name.
                (! empty($member->suffix) ? ' '.$member->suffix : '').
                ' ('.$member->member_id.')'.'</span>';
        } else {
            if (empty($record) === false) {
                $exams = $record->exams;
            } else {
                $this->writeAuditTrail(
                    Auth::user()->id,
                    'create',
                    'exam',
                    null,
                    json_encode(['member_id' => $data['member_id'], 'exams' => []]),
                    'ExamController@update'
                );

                $record = Exam::create(['member_id' => $data['member_id'], 'exams' => []]);
            }

            // Massage the score, make sure that it's reasonably formated

            $exams[strtoupper($data['exam'])] = [
                'score' => $data['score'],
                'date' => $data['date'],
                'entered_by' => Auth::user()->id,
                'date_entered' => date('Y-m-d'),
            ];

            $record->exams = $exams;

            $message =
                '<span class="fi-alert yellow">'.strtoupper($data['exam']).' added to academy coursework for '.
                $member->first_name.' '.
                (! empty($member->middle_name) ? $member->middle_name.' ' : '').$member->last_name.
                (! empty($member->suffix) ? ' '.$member->suffix : '').
                ' ('.$member->member_id.')'.'</span>';
        }
        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'exam',
            null,
            $record->toJson(),
            'ExamController@update'
        );

        $record->save();

        $member->updateLastUpdated();

        event(new GradeEntered(User::where('member_id', $data['member_id'])->first()));

        return Redirect::route('exam.find', ['user' => $member->id])->with('message', $message);
    }

    public function upload()
    {
        if (($redirect = $this->checkPermissions('UPLOAD_EXAMS')) !== true) {
            return $redirect;
        }

        if (Request::file('file')->isValid() === true) {
            // Delete any records in the messages collection, this is a fresh run
            Message::where('source', '=', 'import_grades')->delete();

            $ext = Request::file('file')->getClientOriginalExtension();

            if ($ext != 'xlsx' && $ext != 'ods') {
                return Redirect::route('exam.index')->with('message', 'Only .xlsx files will be accepted');
            }

            Request::file('file')->move(app_path().'/database', 'TRMN Exam grading spreadsheet.xlsx');

            $max_execution_time = ini_get('max_execution_time');
            set_time_limit(0);

            Artisan::call('import:grades');

            Cache::flush();

            if (is_null($max_execution_time) === false) {
                set_time_limit($max_execution_time);
            } else {
                set_time_limit(30);
            }

            return Redirect::route('exam.index')->with('message', 'Exam grades uploaded');
        }
    }

    public function store()
    {
        if (($redirect = $this->checkPermissions('EDIT_GRADE')) !== true) {
            return $redirect;
        }

        $rules = [
            'exam_id' => 'required|unique:exam_list',
            'name' => 'required',
        ];

        $data = Request::all();
        $data['enabled'] = true;

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect(URL::previous())->withErrors($validator)->withInput();
        }

        // updated with the correct collection name.  make sure the field names in the form match up with the names in
        // the model
        $this->writeAuditTrail(
            Auth::user()->id,
            'create',
            'exam_list',
            null,
            json_encode($data),
            'ExamController@store'
        );

        // updated to use the correct model
        ExamList::create($data);

        // This should probably change, exam/index.blade.php is for the soon to be deprecated file upload.
        //  Once the final excel upoad is done, we could probably re-purpose it. I also updated the directory
        // name from exam to exams.
        return Redirect::route('exam.list');
    }

    public function delete()
    {
        try {
            $examId = Request::get('examID');
            $memberNumber = Request::get('memberNumber');

            $examRecord = Exam::where('member_id', '=', $memberNumber)->first();

            if (($redirect = $this->canDeleteExam($examRecord->exams[$examId]['score'])) !== true) {
                return $redirect;
            }

            $exams = Arr::except((array) $examRecord->exams, (string) $examId);

            $examRecord->exams = $exams;

            $this->writeAuditTrail(
                Auth::user()->id,
                'update',
                'exams',
                null,
                $examRecord->toJson(),
                'ExamController@delete'
            );

            $examRecord->save();

            return back()->with('status', $examId.' has been removed from the members academic record.');
        } catch (\Exception $e) {
            return back()
                ->with('status', 'There was a problem removing '.$examId.' from the members academic record');
        }
    }
}
