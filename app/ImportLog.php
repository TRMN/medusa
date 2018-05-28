<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class ImportLog extends Eloquent
{
    protected $fillable = ['source', 'msg'];
}
