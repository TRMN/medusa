<?php


class RegStatusSeeder extends Seeder {

	public function run()
	{
        DB::collection('status')->delete();

        $statuses = ['Active', 'Inactive', 'Pending', 'Suspended', 'Expelled'];

        $this->command->info('Adding Registration Statuses');

        foreach ($statuses as $status) {
            RegStatus::create(['status' => $status]);
        }
	}

}