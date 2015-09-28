<?php

class ExamController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /exam
     *
     * @return Response
     */
    public function index()
    {
        if (( $redirect = $this->checkPermissions('UPLOAD_EXAMS') ) !== true) {
            return $redirect;
        }

        return View::make('exams.index');
    }

    public function upload()
    {
        if (( $redirect = $this->checkPermissions('UPLOAD_EXAMS') ) !== true) {
            return $redirect;
        }

        if (Input::file('file')->isValid() === true) {

            $ext = Input::file('file')->getClientOriginalExtension();

            if ($ext != 'xlsx') {
                return Redirect::route('exam.index')->with('message', 'Only .xlsx files will be accepted');
            }

            Input::file('file')->move(app_path() . '/database', 'TRMN Exam grading spreadsheet.xlsx');

            Artisan::call('import:grades');

            Cache::flush();

            return Redirect::route('exam.index')->with('message', 'Exam grades uploaded');
        }
    }

}