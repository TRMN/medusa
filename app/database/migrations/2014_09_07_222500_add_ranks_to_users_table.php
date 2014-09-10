<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRanksToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'ranks', function( $table ) {
			$table->increments( 'id' );

			$table->string( 'name', 48 );
			$table->string( 'abbreviation', 24 );
			$table->string( 'code', 4 );
			$table->timestamps();
		});

		Schema::table( 'users', function( $table ) { 
			$table->integer( 'rank_id' )->unsigned()->nullable();
			$table->foreign( 'rank_id' )->references( 'id' )->on( 'ranks' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop( 'ranks' );
		Schema::table( 'users', function( $table ) {
			$table->dropColumn( 'rank_id' );
		});
	}

}
