<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Status extends Eloquent
{
    protected $fillable = [
        'status',
    ];
}
