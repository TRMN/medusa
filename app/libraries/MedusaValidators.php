<?php
namespace Medusa\Validators;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Medusa\Permissions\MedusaPermissions;

class MedusaValidators extends Validator
{
    use MedusaPermissions;

    private $_custom_messages = [
        'is_grader' => 'You may only edit exam scores that you have entered',
        'not_self' => 'You may not enter an exam score for yourself',
        'post_dated' => 'You may not enter an exam score with a date in the future',
    ];

    public function __construct($translator, $data, $rules, $messages = [], $customAttributes = [])
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->_set_custom_stuff();
    }

    /**
     * Setup any customizations etc
     *
     * @return void
     */
    protected function _set_custom_stuff()
    {
        //setup our custom error messages
        $this->setCustomMessages($this->_custom_messages);
    }

    protected function validateIsGrader($attribute, $value, $param)
    {
        // Do they have permission to edit any grade?

        if ($this->hasPermissions(['EDIT_GRADE'])) {
            return true;
        }

        if ($exams = \Exam::where('member_id', '=', $this->data['member_id'])->first()) {
            if (empty( $exams->exams[$value] ) === true) {
                return true; // Exam not present, it's a new entry, allow it
            }

            if (empty( $exams->exams[$value]['entered_by'] ) === true) {
                return false; // No entered_by field, only somebody with EDIT_GRADE or ALL_PERMS permissions can edit it
            }
        } else {
            return true; // No exams found, this is a new entry, allow it.
        }

        return ( $exams->exams[$value]['entered_by'] == \Auth::user()->id );
    }

    protected function validateNotSelf($attribute, $value, $param)
    {
        return ($value != \Auth::user()->member_id);
    }

    protected function validatePostDated($attribute, $value, $param)
    {
        $now = Carbon::createFromFormat('Y-m-d', Carbon::tomorrow()->toDateString());
        $examDate = Carbon::createFromFormat('Y-m-d', $value);

        return $examDate->lte($now);
    }

}