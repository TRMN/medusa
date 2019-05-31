<?php

use Illuminate\Database\Migrations\Migration;

class AddUSERMASQ extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->writeAuditTrail(
            'system user',
            'create',
            'permissions',
            null,
            json_encode(['name' => 'USER_MASQ', 'description' => 'Allow a user to masquerade as another user']),
            'add_new_permissions'
        );
        App\Permission::create(['name' => 'USER_MASQ', 'description' => 'Allow a user to masquerade as another user']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App\Permission::where('name', 'USER_MASQ')->delete();
    }
}
