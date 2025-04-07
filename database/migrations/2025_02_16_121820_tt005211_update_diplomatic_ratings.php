<?php

use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateDiplomaticRatings extends Migration
{
    use \App\Common\UpdateRatings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rate_code = 'DIPLOMATIC';
        $ratings = [
            'C-1' => 'Consulate Staff',
            'C-2' => 'Senior Consulate Staff',
            'C-3' => 'Junior Attaché',
            'C-4' => 'Attaché',
            'C-5' => 'Consular Attaché',
            'C-6' => 'Senior Consular Attaché',
            'C-7' => 'Third Secretary',
            'C-8' => 'Second Secretary',
            'C-9' => 'First Secretary',
            'C-10' => 'Senior Administrator',
            'C-11' => 'Foreign Service Officer',
            'C-12' => 'Vice Consul',
            'C-13' => 'Counselor',
            'C-14' => 'Minister-Counselor',
            'C-15' => 'Minister',
            'C-16' => 'Ambassador',
            'C-17' => 'Legate',
            'C-18' => 'Special Envoy',
            'C-19' => 'Permanent Representative',
            'C-20' => 'Minister Resident',
            'C-21' => 'Ambassador at Large',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'CIVIL', $ratings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
