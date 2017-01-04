<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ErrorList extends Eloquent
{
    protected $fillable = [ 'severity', 'source', 'msg' ];

    protected $table = 'error_list';
}
