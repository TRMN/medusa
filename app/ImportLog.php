<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ImportLog extends Eloquent
{
    protected $fillable = ['source', 'msg'];
}
