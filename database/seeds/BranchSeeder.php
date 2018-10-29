<?php
/**
 * Created by PhpStorm.
 * User: dweiner
 * Date: 10/6/14
 * Time: 4:45 PM.
 */
class BranchSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        DB::collection('branches')->delete();

        $branches = [
            'RMA'   => 'Royal Manticoran Army',
            'RMMC'  => 'Royal Manticoran Marine Corp',
            'RMN'   => 'Royal Manticoran Navy',
            'GSN'   => 'Grayson Space Navy',
            'IAN'   => 'Imperial Andermani Navy',
            'RHN'   => 'Republic of Haven Navy',
            'CIVIL' => 'Civil Service/Government and Diplomatic Corp',
            'INTEL' => 'Civil Service/Espionage and Intelligence',
            'SFS'   => 'Civil Service/Sphinx Forestry Service',
        ];

        foreach ($branches as $branch => $name) {
            $this->command->comment('Creating '.$name.' branch');

            $this->writeAuditTrail(
                'db:seed',
                'create',
                'billets',
                null,
                json_encode(['branch' => $branch, 'branch_name' => $name]),
                'billet'
            );

            Branch::create(['branch' => $branch, 'branch_name' => $name]);
        }
    }
}
