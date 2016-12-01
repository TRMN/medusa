<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;



class ExamList extends Model
{
    protected $fillable = [ 'exam_id', 'name', 'enabled'];

    protected $table = 'exam_list';
}
