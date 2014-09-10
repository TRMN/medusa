<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'users', function( Blueprint $table )
		{
			$table->increments( 'id' )->unsigned();
			$table->string( 'first_name' );
			$table->string( 'last_name' );
			$table->string( 'password' );
			$table->string( 'member_id' )->index();
			$table->string( 'city' );
			$table->string( 'state' );
			$table->string( 'zip' );
			$table->string( 'country' );
			$table->string( 'email' )->unique();
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
