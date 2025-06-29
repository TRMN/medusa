<?php

use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateSfcPaygrades extends Migration
{
    use \App\Common\UpdatePaygrades;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $branch = 'SFC';
        $paygrades = [
            'C-1' => 'Assistant Ranger',
            'C-2' => 'Ranger',
            'C-3' => 'Ranger II',
            'C-4' => 'Ranger III',
            'C-5' => 'Senior Ranger',
            'C-6' => 'Senior Ranger II',
            'C-7' => 'Senior Ranger III',
            'C-8' => 'Deputy Chief Ranger',
            'C-9' => 'Chief Ranger',
            'C-10' => 'Senior Chief Ranger',
            'C-11' => 'Ranger 2nd Lieutenant',
            'C-12' => 'Ranger 1st Lieutenant',
            'C-13' => 'Ranger Captain',
            'C-14' => 'Ranger Major',
            'C-15' => 'Ranger Lieutenant Colonel',
            'C-16' => 'Ranger Colonel',
            'C-17' => 'Ranger Brigadier General',
            'C-18' => 'Ranger Major General',
            'C-19' => 'Ranger Lieutenant General',
            'C-20' => 'Ranger General',
            'C-21' => 'Ranger Marshal',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_paygrades($branch, $paygrades);
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
