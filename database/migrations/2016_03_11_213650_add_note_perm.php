<?php

use Illuminate\Database\Migrations\Migration;

class AddNotePerm extends Migration
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
            'VIEW_NOTE'  => 'Add a BuPers Note',
            'EDIT_NOTE'  => 'Edit a BuPers Note',
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
        }//
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
