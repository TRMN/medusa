<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Moloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    public static $rules = [
        'member_id' => 'required|size:11|unique:users',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'address_1' => 'required|min:4',
        'city' => 'required|min:2',
        'state_province' => 'required|min:2',
        'postal_code' => 'required|min:2',
        'country' => 'required',
        'email_address' => 'required|email|unique:users',
        'branch' => 'required',
        'perm_dor' => 'date|date_format:Y-m-d|required_with:permanent_rank',
        'brevet_dor' => 'date|date_format:Y-m-d|required_with:brevet_rank',
        'primary_assignment' => 'required',
        'primary_date_assigned' => 'required|date|date_format:Y-m-d',
        'secondary_date_assigned' => 'date|date_format:Y-m-d|required_with:secondary_assignment'
    ];

    public static $error_message = [
        'member_id.required' => 'A Member ID is required',
        'member_id.size' => 'The Member ID must follow the format RMN-XXXX-YY',
        'member_id.unique' => 'That member ID is already in use',
        'min' => 'The members :attribute must be at least :min characters long',
        'address_1.required' => 'Please enter the members street address',
        'address_1.min' => 'The street address must be at least :size characters long',
        'required' => 'Please enter the members :attribute',
        'state_province.required' => 'Please enter the members state or province',
        'state_province.min' => 'The members state or province must be at least :size character long',
        'perm_dor.required_with' => 'If a permanent rank has been selected, a date of rank must be entered',
        'perm_dor.date' => 'The permanent date of rank must be a valid date',
        'brevet_dor.required_with' => 'If a brevet rank has been selected, a date of rank must be entered',
        'brevet_dor.date' => 'The permanent date of rank must be a valid date',
        'date_format' => 'Please enter a date in the format YYYY-MM-DD',
        'primary_assignment.required' => "Please select the members primary chapter assignment",
        'primary_date_assigned.required' => 'Please enter the date the member was assigned to their primary chapter',
        'secondary_date_assigned.required_with' => 'Please enter the date the member was assigned to their secondary chapter',
        'branch.required' => "Please select the members branch",
        'email_address.unique' => 'That email address is already in use',
    ];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $fillable = [ 'member_id', 'first_name', 'middle_name', 'last_name', 'suffix', 'address_1', 'address_2', 'city', 'state_province', 'postal_code', 'country', 'email_address', 'branch', 'rating', 'rank', 'assignment', 'peerage_record', 'awards_record', 'exam_record'];

    public function formalName()
    {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function chapters()
    {
        return $this->belongsToMany( 'Chapter' );
    }
}
