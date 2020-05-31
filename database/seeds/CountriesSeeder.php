<?php


class CountriesSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Empty the countries table
        DB::table(\Config::get('laravel-countries::table_name'))->delete();

        //Get all of the countries
        $countries = Countries::getList();
        foreach ($countries as $countryId => $country) {
            $this->writeAuditTrail(
                'db:seed',
                'create',
                \Config::get('laravel-countries::table_name'),
                null,
                json_encode(
                    [
                        'id' => $countryId,
                        'capital' => ((isset($country['capital'])) ? $country['capital'] : null),
                        'citizenship' => ((isset($country['citizenship'])) ? $country['citizenship'] : null),
                        'country_code' => $country['country-code'],
                        'currency' => ((isset($country['currency'])) ? $country['currency'] : null),
                        'currency_code' => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
                        'currency_sub_unit' => ((isset($country['currency_sub_unit'])) ? $country['currency_sub_unit'] : null),
                        'full_name' => ((isset($country['full_name'])) ? $country['full_name'] : null),
                        'iso_3166_2' => $country['iso_3166_2'],
                        'iso_3166_3' => $country['iso_3166_3'],
                        'name' => $country['name'],
                        'region_code' => $country['region-code'],
                        'sub_region_code' => $country['sub-region-code'],
                        'eea' => (bool)$country['eea'],
                    ]
                ),
                'contries'
            );

            DB::table(\Config::get('laravel-countries::table_name'))->insert([
                'id' => $countryId,
                'capital' => ((isset($country['capital'])) ? $country['capital'] : null),
                'citizenship' => ((isset($country['citizenship'])) ? $country['citizenship'] : null),
                'country_code' => $country['country-code'],
                'currency' => ((isset($country['currency'])) ? $country['currency'] : null),
                'currency_code' => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
                'currency_sub_unit' => ((isset($country['currency_sub_unit'])) ? $country['currency_sub_unit'] : null),
                'full_name' => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'iso_3166_2' => $country['iso_3166_2'],
                'iso_3166_3' => $country['iso_3166_3'],
                'name' => $country['name'],
                'region_code' => $country['region-code'],
                'sub_region_code' => $country['sub-region-code'],
                'eea' => (bool)$country['eea'],
            ]);
        }
    }
}
