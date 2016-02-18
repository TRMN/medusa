<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmptyPeeragesToUsers extends Migration {

    // Structure change only, no audit trail required

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        foreach (User::all() as $user) {
            $user->peerages = [];
            $user->save();
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
