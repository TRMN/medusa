<?php

use Illuminate\Database\Migrations\Migration;

class AddPrivyCouncil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $privyCouncil = [
            'display_order' => 2001,
            'name' => 'Member, Privy Council',
            'code' => 'PC',
            'post_nominal' => 'PC',
            'location' => 'LS',
            'multiple' => false,
            'star_nation' => 'manticore',
        ];

        App\Award::create($privyCouncil);
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
