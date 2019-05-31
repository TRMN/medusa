<?php

use Illuminate\Database\Migrations\Migration;

class AddPromoteO2 extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'PROMOTE_E6O2'  => 'Promote to E6/O2',
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
        App\Models\Permission::where('name', 'PROMOTE_E6O2')->first()->delete();
    }
}
