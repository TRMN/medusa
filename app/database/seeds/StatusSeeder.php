<?php

class StatusSeeder extends Seeder
{

    public function run()
    {
        DB::collection('statuses')->delete();

        $statuses = ['Active', 'Denied', 'Pending', 'Suspended', 'Expelled'];

        foreach ($statuses as $status) {
            $this->command->comment('Adding ' . $status);
            Status::create(["status" => $status]);
        }
    }
}