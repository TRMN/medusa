<?php

use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['source', 'severity', 'msg'];
}
