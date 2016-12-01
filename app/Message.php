<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;




class Message extends Model
{
    protected $fillable = ['source', 'severity', 'msg'];
}
