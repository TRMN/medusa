<?php

use Illuminate\Database\Migrations\Migration;

class AddDobPerms extends Migration
{
    use \App\Models\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'DOB'  => 'See Date of Birth',
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(['name' => $perm, 'description' => $desc]),
                'add_dob_perms'
            );
            App\Models\Permission::create(['name' => $perm, 'description' => $desc]);
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
