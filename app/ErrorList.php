<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorList extends Model
{
    protected $fillable = [ 'severity', 'source', 'msg' ];

    protected $table = 'error_list';
}
