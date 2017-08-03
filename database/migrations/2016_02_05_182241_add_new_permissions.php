<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class AddNewPermissions extends Migration
{

    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'ADD_PEERAGE'  => 'Add a peerage',
            'DEL_PEERAGE'  => 'Delete a peerage',
            'EDIT_PEERAGE' => 'Edit a peerage'
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
