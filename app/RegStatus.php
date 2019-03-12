<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class RegStatus extends Eloquent
{
    protected $fillable = ['status'];

    protected $table = 'status';

    public static function getRegStatuses()
    {
        $retVal = [];

        foreach (self::orderBy('status')->get() as $status) {
            $retVal[$status->status] = $status->status;
        }

        asort($retVal);

        return ['' => 'Select a status'] + $retVal;
    }
}
