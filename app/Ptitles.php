<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Ptitles extends Eloquent
{
    protected $fillable = ['title', 'code', 'precedence'];

    protected $table = 'ptitles';
}
