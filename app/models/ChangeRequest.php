<?php

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChangeRequest extends Eloquent {
	protected $fillable = ['user', 'requestor', 'req_type', 'old_value', 'new_value'];
}