<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'users', function( Blueprint $table ) {
            $table->increments( 'id' )->unsigned();
            $table->string( 'email' )->unique();
            $table->string( 'name' );
            $table->string( 'password' );
            $table->string( 'member_id', 20 )->index();
            $table->string( 'zipcode', 8 );
            $table->rememberToken();

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
        Schema::drop( 'users' );
    }

}
