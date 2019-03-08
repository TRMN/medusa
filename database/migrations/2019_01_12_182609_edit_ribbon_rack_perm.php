<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRibbonRackPerm extends Migration
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
            'EDIT_RR'  => 'Edit Users Ribbon Rack'
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(['name' => $perm, 'description' => $desc]),
                'add_new_permissions'
            );
            App\Permission::create(['name' => $perm, 'description' => $desc]);
        }

        // Add the new permission to the 5SL and Dir MDOC

        foreach (['RMN-1094-12', 'RMN-0927-12'] as $member_id) {
            $user = \App\User::where('member_id', $member_id)->first();
            $user->updatePerms(['EDIT_RR']);
            $user->save();
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
