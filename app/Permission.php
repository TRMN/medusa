<?php

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Permission extends Eloquent
{
    protected $fillable = ['name', 'description'];
}
