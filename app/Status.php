<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Status extends Eloquent
{
    protected $fillable = [
        'status',
    ];
}
