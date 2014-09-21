<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    public static $rules = [];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $fillable = [ 'first_name', 'last_name', 'email', 'member_id' ];

    public function formalName() {
        return $this->last_name . ', ' . $this->first_name;
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function chapters() {
        return $this->belongsToMany( 'Chapter' ); // make this polymorphic
    }
}