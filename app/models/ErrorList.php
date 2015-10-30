<?php
use Jenssegers\Mongodb\Model as Eloquent;

class ErrorList extends Eloquent {
	protected $fillable = [ 'severity', 'source', 'msg' ];

    protected $table = 'error_list';
}