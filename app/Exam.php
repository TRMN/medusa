<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Exam extends Eloquent
{
    protected $fillable = ['member_id', 'exams'];
}
