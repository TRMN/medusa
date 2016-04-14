<?php
use Jenssegers\Mongodb\Model as Eloquent;

class ExamList extends Eloquent {
	protected $fillable = [ 'id', 'name'];

    protected $table = 'exam_list';
}