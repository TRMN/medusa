<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewMinorPiiPerm extends Migration
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
            'VIEW_MINOR_PII' => 'Can view the PII of minors',
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

        // Add the new permission to the Dir MDOC and 5SL

        foreach (['RMN-1094-12', 'RMN-4637-17'] as $member_id) {
            $user = \App\User::where('member_id', $member_id)->first();
            $user->updatePerms(['VIEW_MINOR_PII']);
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
