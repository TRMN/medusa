<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Eloquent;

class Type extends Model
{

    protected $fillable = [ 'chapter_type', 'chapter_description', 'can_have'];
}
