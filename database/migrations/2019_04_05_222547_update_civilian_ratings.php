<?php

use Illuminate\Database\Migrations\Migration;

class UpdateCivilianRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * @var App\User
         */
        foreach (App\User::where('branch', 'CIVIL')->get() as $user) {
            if (empty($user->rating) === true) {
                $user->rating = 'DIPLOMATIC';
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
        //
    }
}
