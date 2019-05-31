<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Ptitles extends Eloquent
{
    protected $fillable = ['title', 'code', 'precedence'];

    protected $table = 'ptitles';
}
