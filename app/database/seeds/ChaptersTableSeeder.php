<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ChaptersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach( range( 1, 10 ) as $index )
		{
			Chapter::create([
                'title' => 'Test Chapter ' . $index,
                'crest' => 'test-chapter-' . $index . '.jpg',
			]);
		}
	}

}