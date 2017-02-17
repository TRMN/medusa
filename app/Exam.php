<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Exam extends Eloquent
{
    protected $fillable = ['member_id', 'exams'];
}
