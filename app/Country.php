<?php

namespace App;

use Webpatser\Countries\Countries;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
    protected $fillable = [];

    public static function getCountries()
    {
        $contries = new Countries();
        $results = $contries->getList();
        $countries = [];

        foreach ($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        $countries = ['' => 'Select a Country'] + $countries;

        return $countries;
    }
}
