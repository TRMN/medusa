<?php
use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class ExamList extends Model
{
    protected $fillable = [ 'exam_id', 'name', 'enabled'];

    protected $table = 'exam_list';
}
