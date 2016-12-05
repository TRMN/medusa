<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tig extends Model
{

    protected $collection = "tig";

    protected $fillable = [ 'grade', 'tig' ];
}
