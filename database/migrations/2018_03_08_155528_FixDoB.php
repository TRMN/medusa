<?php

use Illuminate\Database\Migrations\Migration;

class FixDoB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (\App\User::where('dob', 'regex', '/^\d{1,2}-\d{1,2}-\d{1,2}$/')->get() as $member) {
            $dob = explode('-', $member->dob);

            if ($dob[0] > 12) {
                // More than likely this is the year
                $member->dob = sprintf('19%2d-%02d-%02d', $dob[0], $dob[1], $dob[2]);
            } else {
                // More than likely, this is the month
                $member->dob = sprintf('19%2d-%02d-%02d', $dob[2], $dob[0], $dob[1]);
            }

            $member->save();
        }
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
