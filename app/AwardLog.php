<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class AwardLog extends Eloquent
{
    protected $fillable = ['timestamp', 'member_id', 'award', 'qty'];
}
