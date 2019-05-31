<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Tig extends Eloquent
{
    protected $collection = 'tig';

    protected $fillable = ['grade', 'tig'];
}
