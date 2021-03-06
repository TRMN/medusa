<?php

use Illuminate\Database\Migrations\Migration;

class AddGunnyBillet extends Migration
{
    use \App\Audit\MedusaAudit;

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
            'billets',
            null,
            json_encode(['billet_name' => 'Gunny']),
            'add_flag_lt'
        );
        App\Billet::create(['billet_name' => 'Gunny']);
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
