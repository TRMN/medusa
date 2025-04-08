<?php

use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateIntelRatings extends Migration
{
    use \App\Common\UpdateRatings;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rate_code = 'INTEL';
        $ratings = [
            'C-1' => 'Analyst',
            'C-2' => 'Senior Analyst',
            'C-3' => 'Junior Agent',
            'C-4' => 'Agent 3rd Class',
            'C-5' => 'Agent 2nd Class',
            'C-6' => 'Agent 1st Class',
            'C-7' => 'Senior Agent',
            'C-8' => 'Supervising Agent',
            'C-9' => 'Section Chief',
            'C-10' => 'Station Supervisor',
            'C-11' => 'Special Agent 3rd Class',
            'C-12' => 'Special Agent 2nd Class',
            'C-13' => 'Special Agent 1st Class',
            'C-14' => 'Senior Special Agent',
            'C-15' => 'Principal Agent',
            'C-16' => 'System Agent',
            'C-17' => 'Regional Agent',
            'C-18' => 'Sector Agent',
            'C-19' => 'Quadrant Agent',
            'C-20' => 'Department Director',
            'C-21' => 'Bureau Head',
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
