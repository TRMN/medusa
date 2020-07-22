<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Webpatser\Countries\Countries;

class Country extends Eloquent
{
    protected $fillable = [];

    public static function getCountries()
    {
        $countryLister = new Countries();
        $results = $countryLister->getList();
        $countries = [];

        foreach ($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        $countries = ['' => 'Select a Country'] + $countries;

        return $countries;
    }
}
