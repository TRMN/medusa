<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class Type extends Eloquent
{

    protected $fillable = [ 'chapter_type', 'chapter_description', 'can_have'];
}
