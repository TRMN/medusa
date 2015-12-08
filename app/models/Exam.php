<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Exam extends Eloquent {
    protected $fillable = ['member_id', 'exams'];
}