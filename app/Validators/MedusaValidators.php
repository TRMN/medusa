<?php

namespace App\Validators;

use App\Exam;
use App\Permissions\MedusaPermissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class MedusaValidators extends Validator
{
    use MedusaPermissions;

    private $custom_messages = [
        'is_grader'   => 'You may only edit exam scores that you have entered or do not have a failing grade',
        'not_self'    => 'You may not enter an exam score for yourself',
        'post_dated'  => 'You may not enter an exam score with a date in the future',
        'valid_grade' => 'Only PASS, BETA, CREATE, 0 or a score between 70 and 100 are valid',
    ];

    public function __construct($translator, $data, $rules, $messages = [], $customAttributes = [])
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->setCustomStuff();
    }

    /**
     * Setup any customizations etc.
     *
     * @return void
     */
    protected function setCustomStuff()
    {
        //setup our custom error messages
        $this->setCustomMessages($this->custom_messages);
    }

    protected function validateIsGrader($attribute, $value, $param)
    {
        if ($exams =
            Exam::where('member_id', '=', $this->data['member_id'])->first()) {
            // Is this a fail grade?  If yes, than only limited people can edit it.
            if (empty($exams->exams[$value]) === false &&
                rtrim($exams->exams[$value]['score'], '%') == '0' &&
                $this->hasPermissions(['UPLOAD_EXAMS']) === false) {
                return false; // Failed exam, not authorized to change grade.
            }

            // Has permission to edit any grade?
            if ($this->hasPermissions(['EDIT_GRADE'])) {
                return true;
            }

            if (empty($exams->exams[$value]) === true) {
                return true; // Exam not present, it's a new entry, allow it
            }

            if (empty($exams->exams[$value]['entered_by']) === true) {
                return false; // No entered_by field, only somebody with EDIT_GRADE or ALL_PERMS permissions can edit it
            }
        } else {
            return true; // No exams found, this is a new entry, allow it.
        }

        return $exams->exams[$value]['entered_by'] == Auth::user()->id;
    }

    protected function validateNotSelf($attribute, $value, $param)
    {
        return $value != Auth::user()->member_id;
    }

    protected function validatePostDated($attribute, $value, $param)
    {
        $value = date('Y-m-d', strtotime($value));

        return Carbon::createFromFormat('Y-m-d', $value)->
                lte(Carbon::createFromFormat('Y-m-d', Carbon::tomorrow()->
                toDateString()));
    }

    protected function validateValidGrade($attribute, $value, $param)
    {
        // Do we have a numeric score?
        if (intval($value) != $value) {
            // Not a numeric score, check for valid alpha scores.
            return in_array(strtoupper($value), ['PASS', 'BETA', 'CREATE']);
        } else {
            return intval($value) === 0 || ($value >= 70 && $value <= 100);
        }
    }
}
