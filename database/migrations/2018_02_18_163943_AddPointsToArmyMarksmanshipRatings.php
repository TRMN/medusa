<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AddPointsToArmyMarksmanshipRatings.
 */
class AddPointsToArmyMarksmanshipRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $patterns = [
          'A%ER'  => 3,
          'A%SR'  => 2,
          'A%MR'  => 1,
          'A%HER' => 4,
        ];

        foreach ($patterns as $pattern => $points) {
            foreach (\App\Models\Award::where('code', 'like', $pattern)->get() as $award) {
                $award->points = $points;
                $award->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Award::where('code', 'like', 'A%R')->unset('code');
    }
}
