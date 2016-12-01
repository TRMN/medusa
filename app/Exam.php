<?php

use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['member_id', 'exams'];
}
