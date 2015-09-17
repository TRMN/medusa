<?php


class RegStatusSeeder extends Seeder
{

    use \Medusa\Audit\MedusaAudit;

	public function run()
	{
        DB::collection('status')->delete();

        $statuses = ['Active', 'Inactive', 'Pending', 'Suspended', 'Expelled'];

        $this->command->info('Adding Registration Statuses');

        foreach ($statuses as $status) {

            $this->writeAuditTrail(
                'db:seed',
                'create',
                'status',
                null,
                json_encode(['status' => $status]),
                'regstatus'
            );

            RegStatus::create(['status' => $status]);
        }
	}

}