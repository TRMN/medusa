<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Moloquent\Eloquent\SoftDeletes;

class ChangeRequest extends Eloquent
{
    use SoftDeletes;

    protected $fillable = ['user', 'requestor', 'req_type', 'old_value', 'new_value', 'status'];
}
