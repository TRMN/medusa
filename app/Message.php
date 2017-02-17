<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
    protected $fillable = ['source', 'severity', 'msg'];
}
