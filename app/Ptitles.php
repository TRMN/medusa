<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;

class Ptitles extends Model
{
    protected $fillable = ['title', 'code', 'precedence'];

    protected $table = 'ptitles';
}
