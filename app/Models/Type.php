<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Type extends Eloquent
{
    protected $fillable = ['chapter_type', 'chapter_description', 'can_have'];
}
