<?php

use Illuminate\Database\Migrations\Migration;

class AddNationToAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $awards = \App\Models\Award::all();

        foreach ($awards as $award) {
            $award->star_nation = 'manticore';
            $award->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $awards = \App\Models\Award::all();

        foreach ($awards as $award) {
            $award->unset('star_nation');
            $award->save();
        }
    }
}
