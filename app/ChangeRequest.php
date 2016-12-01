<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Model as Eloquent;




class ChangeRequest extends Model
{

    use \Jenssegers\Mongodb\Eloquent\SoftDeletes;

    protected $fillable = ['user', 'requestor', 'req_type', 'old_value', 'new_value', 'status'];
}
