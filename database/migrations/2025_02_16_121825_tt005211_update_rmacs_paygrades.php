<?php

use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmacsPaygrades extends Migration
{
    use \App\Common\UpdatePaygrades;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $branch = 'RMACS';
        $paygrades = [
            'C-1' => 'Recruit',
            'C-2' => 'Trainee',
            'C-3' => 'Candidate',
            'C-4' => 'Petty Officer Third Class',
            'C-5' => 'Petty Officer Second Class',
            'C-6' => 'Petty Officer First Class',
            'C-7' => 'Chief Petty Officer',
            'C-8' => 'Senior Chief Petty Officer',
            'C-9' => 'Master Chief Petty Officer',
            'C-10' => 'Senior Master Chief Petty Officer',
            'C-11' => 'Ensign',
            'C-12' => 'Lieutenant (JG)',
            'C-13' => 'Lieutenant (SG)',
            'C-14' => 'Lieutenant Commander',
            'C-15' => 'Commander',
            'C-16' => 'Captain',
            'C-17' => 'Commodore',
            'C-18' => 'Rear Admiral',
            'C-19' => 'Vice Admiral',
            'C-20' => 'Admiral',
            'C-21' => 'Fleet Admiral',
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
