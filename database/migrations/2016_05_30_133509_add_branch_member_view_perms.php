<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchMemberViewPerms extends Migration
{

    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'VIEW_RMN'  => 'View RMN members',
            'VIEW_RMMC'  => 'View RMMC members',
            'VIEW_RMA' => 'View RMA members',
            'VIEW_GSN' => 'View GSN members',
            'VIEW_IAN' => 'View IAN members',
            'VIEW_RHN' => 'View RHN members',
            'VIEW_CIVIL' => 'View CIVIL members',
            'VIEW_SFS' => 'View SFS members',
            'VIEW_RMACS' => 'View RMACS members',
            'VIEW_RMMM' => 'View RMMM members',
            'VIEW_INTEL' => 'View INTEL members',
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(["name" => $perm, "description" => $desc]),
                'add_new_permissions'
            );
            Permission::create(["name" => $perm, "description" => $desc]);
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
