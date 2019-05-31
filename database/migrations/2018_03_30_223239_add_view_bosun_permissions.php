<?php

use Illuminate\Database\Migrations\Migration;

class AddViewBosunPermissions extends Migration
{
    use \App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $newPerms = [
            'VIEW_BOSUN' => 'View Bosun List',
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
        $bosunPerm = \App\Models\Permission::where('name', 'VIEW_BOSUN')->first();
        \App\Models\Permission::destroy($bosunPerm->id);
    }
}
