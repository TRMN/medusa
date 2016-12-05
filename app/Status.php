<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;




class Status extends Model
{
    protected $fillable = [
        'status',
    ];
}
