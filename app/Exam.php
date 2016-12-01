<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;




class Exam extends Model
{
    protected $fillable = ['member_id', 'exams'];
}
