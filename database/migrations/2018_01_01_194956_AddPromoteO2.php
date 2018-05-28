<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class AddPromoteO2 extends Migration
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
            'PROMOTE_E6O2'  => 'Promote to E6/O2',
        ];

        foreach ($newPerms as $perm => $desc) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'permissions',
                null,
                json_encode(["name" => $perm, "description" => $desc]),
                'add_dob_perms'
            );
            App\Permission::create(["name" => $perm, "description" => $desc]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App\Permission::where('name', 'PROMOTE_E6O2')->first()->delete();
    }
}
