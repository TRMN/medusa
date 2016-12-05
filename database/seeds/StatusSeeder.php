<?php

class StatusSeeder extends Seeder
{

    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection('statuses')->delete();

        $statuses = ['Active', 'Denied', 'Pending', 'Suspended', 'Expelled'];

        foreach ($statuses as $status) {
            $this->command->comment('Adding ' . $status);

            $this->writeAuditTrail(
                'db:seed',
                'create',
                'statuses',
                null,
                json_encode(['status' => $status]),
                'status'
            );

            Status::create(["status" => $status]);
        }
    }
}
