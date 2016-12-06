<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Countries\Countries;

class Country extends Model
{
    protected $fillable = [];

    public static function getCountries()
    {
        $results = Countries::getList();
        $countries = [];

        foreach ($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        asort($countries);

        $countries = ['' => 'Select a Country'] + $countries;

        return $countries;
    }
}
