<?php

use Illuminate\Database\Migrations\Migration;

class FixRMMMRanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $lookup = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'Spacer 2',
            'C-3' => 'Spacer 3',
            'C-6' => 'Spacer 4',
            'C-7' => 'Spacer 5',
            'C-8' => 'Spacer 6',
            'C-12' => 'Fourth Officer',
            'C-13' => 'Civilian 13',
            'C-15' => 'Civilian 15',
            'C-16' => 'Civilian 16',
            'C-17' => 'Civilian 17',
            'C-18' => 'Fleet Manager',
            'C-19' => 'Superintendent',
            'C-20' => 'Managing Director',
            'C-21' => 'Owner',
            'C-22' => 'Trade Minister',
        ];

        // Update the RMMM Ranks

        foreach (\App\Grade::where('grade', 'like', 'C-%')->get() as $grade) {
            $rank = $grade->rank;
            if (empty($lookup[$grade->grade]) === true) {
                unset($rank['RMMM']);
            } else {
                $rank['RMMM'] = $lookup[$grade->grade];
            }
            $grade->rank = $rank;
            $grade->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // None, this is not a reversabile change
    }
}
