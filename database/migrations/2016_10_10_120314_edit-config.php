<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditConfig extends Migration
{

    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the new permissions

        $newPerms = [
            'CONFIG'  => 'Manage system config settings',
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(["name" => $perm, "description" => $desc]),
                'add_config_perms'
            );
            App\Permission::create(["name" => $perm, "description" => $desc]);
        }

        // Assign the new permission to Dave and Eric only

        foreach (['RMN-1094-12', 'RMN-2470-14'] as $admin) {
            App\User::getUserByMemberId($admin)->updatePerms(['CONFIG']);
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
