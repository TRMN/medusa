<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

    protected $hidden = [ 'password', 'remember_token' ];

	// Don't forget to fill this array
	protected $fillable = [ 'first_name', 'last_name', 'email', 'member_id' ];

}