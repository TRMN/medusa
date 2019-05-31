<?php

use Illuminate\Database\Migrations\Migration;

class AddNewBranches extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newBranches = [
            'RMMM'  => 'Royal Manticoran Merchant Marines',
            'RMACS' => 'Royal Manticoran Astro Control Service',
        ];

        foreach ($newBranches as $branch => $name) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'brances',
                null,
                json_encode(['branch' => $branch, 'branch_name' => $name]),
                'add_new_branches'
            );

            Branch::create(['branch' => $branch, 'branch_name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['RMMM', 'RMACS'] as $value) {
            $branch = Branch::where('branch', '=', $value)->first();
            if (empty($branch) === false) {
                $this->writeAuditTrail(
                    'system user',
                    'delete',
                    'brances',
                    $branch->id,
                    $branch->toJson(),
                    'add_new_branches (rollback)'
                );

                $branch->delete();
            }
        }
    }
}
