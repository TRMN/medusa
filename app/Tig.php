<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Tig extends Eloquent
{
    protected $collection = 'tig';

    protected $fillable = ['grade', 'tig'];
}
