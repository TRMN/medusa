<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

class AwardLog extends Eloquent
{
    protected $fillable = ['timestamp', 'member_id', 'award', 'qty'];

    public static function getAwardLogData($params = [])
    {
        if (empty($params) === true) {
            // Return everything
            return self::all();
        }

        $query = new AwardLog();

        foreach ($params as $param => $value) {
            switch ($param) {
                case 'start':
                    $query = $query->where('timestamp', '>=', strtotime($value));
                    break;
                case 'end':
                    $query = $query->where('timestamp', '<=', strtotime($value));
                    break;
                case 'award':
                    $query = $query->where('award', $value);
                    break;
                case 'member_id':
                    $query = $query->where('member_id', $value);
                    break;
            }
        }

        return $query->get();
    }
}
