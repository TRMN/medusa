<?php
use Jenssegers\Mongodb\Model as Eloquent;

class ExamList extends Eloquent {
	protected $fillable = [ 'exam_id', 'name', 'enabled'];

    protected $table = 'exam_list';
}