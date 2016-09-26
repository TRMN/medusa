<?php
use Jenssegers\Mongodb\Model as Eloquent;

class Event extends Eloquent {
	protected $fillable = [
	    'event_name',
        'address1',
        'address2',
        'city',
        'state_province',
        'postal_code',
        'country',
        'start_date',
        'end_date',
        'requestor',
        'authorized_users'
    ];

    public static $rules = [
        'event_name' => 'required',
        'address1' => 'required',
        'city' => 'required',
        'state_province' => 'required',
        'postal_code' => 'required',
        'country' => 'required',
        'start_date' => 'required'
        ];

    public static $updateRules = [
        ];
}