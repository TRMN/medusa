<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShipsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'chapters_ships', function( Blueprint $table )
        {
            $table->increments( 'id' )->unsigned();
            $table->integer( 'xo' )->unsigned();
            $table->integer( 'bosun' )->unsigned();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'chapters_ships' );
    }

}
