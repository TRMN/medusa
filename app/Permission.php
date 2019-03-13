<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Permission extends Eloquent
{
    protected $fillable = ['name', 'description'];
}
