<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Status extends Eloquent
{
    protected $fillable = [
        'status',
    ];
}
