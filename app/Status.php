<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Status extends Eloquent
{
    protected $fillable = [
        'status',
    ];
}
