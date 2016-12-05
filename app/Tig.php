<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Tig extends Eloquent
{

    protected $collection = "tig";

    protected $fillable = [ 'grade', 'tig' ];
}
