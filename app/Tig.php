<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;




class Tig extends Model
{

    protected $collection = "tig";

    protected $fillable = [ 'grade', 'tig' ];
}
