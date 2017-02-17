<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Permission extends Eloquent
{
    protected $fillable = ['name', 'description'];
}
