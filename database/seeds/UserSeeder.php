<?php

class UserSeeder extends Seeder {

	public function run()
	{
        DB::collection( 'users' )->delete();
	}

}