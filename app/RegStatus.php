<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Model as Eloquent;




class RegStatus extends Model
{
    protected $fillable = ['status'];

    protected $table = 'status';

    static function getRegStatuses()
    {
        $retVal = [];

        foreach (self::orderBy('status')->get() as $status) {
            $retVal[$status->status] = $status->status;
        }

        asort($retVal);

        return ['' => 'Select a status'] + $retVal;
    }
}
