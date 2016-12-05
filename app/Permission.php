<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Model as Eloquent;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];
}
