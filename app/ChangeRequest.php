<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ChangeRequest extends Eloquent
{

    use \Jenssegers\Mongodb\Eloquent\SoftDeletes;

    protected $fillable = ['user', 'requestor', 'req_type', 'old_value', 'new_value', 'status'];
}
