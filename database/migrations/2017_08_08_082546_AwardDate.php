<?php

use Illuminate\Database\Migrations\Migration;

class AwardDate extends Migration
{
    /**
     * Add award_date to members awards.
     *
     * @return void
     */
    public function up()
    {
        // Get all the users

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            // Get the awards for the user

            if (isset($user->awards) === true) {
                $awards = $user->awards;

                // iterate through the awards and add award_date array and set it to 1 JAN 1970 for each instance
                foreach ($awards as $award => $awardInfo) {
                    $awardInfo['award_date'] = array_fill(0, $awardInfo['count'], '1970-01-01');

                    $awards[$award] = $awardInfo;
                }

                $user->awards = $awards;
                $user->save();
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
        // Get all the users

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            // Get the awards for the user

            if (isset($user->awards) === true) {
                $awards = $user->awards;

                // iterate through the awards and add award_date array and set it to 1 JAN 1970 for each instance
                foreach ($awards as $award => $awardInfo) {
                    unset($awardInfo['award_date']);

                    $awards[$award] = $awardInfo;
                }

                $user->awards = $awards;
                $user->save();
            }
        }
    }
}
