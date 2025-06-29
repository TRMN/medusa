<?php

use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmMedicalRatings extends Migration
{
    use \App\Common\UpdateRatings;
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rate_code = 'MEDICAL';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Medical Aide',
            'C-4' => 'Medical Assistant',
            'C-5' => 'Medical Technician',
            'C-6' => 'Paramedic',
            'C-7' => 'Sick Berth Attendant',
            'C-8' => 'Senior Sick Berth Attendant',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Nursing Assistant',
            'C-12' => 'Nurse',
            'C-13' => 'Senior Nurse',
            'C-14' => 'Practical Nurse',
            'C-15' => 'Assistant Merchant Surgeon',
            'C-16' => 'Merchant Surgeon',
            'C-17' => 'Fleet Medical Director',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
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
