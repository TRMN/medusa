<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;

class ErrorList extends Model
{
    protected $fillable = [ 'severity', 'source', 'msg' ];

    protected $table = 'error_list';
}
