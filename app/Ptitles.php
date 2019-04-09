<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Ptitles extends Eloquent
{
    protected $fillable = ['title', 'code', 'precedence'];
}
