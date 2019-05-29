<?php

use Illuminate\Database\Migrations\Migration;

class AddFleetCoLiaiason extends Migration
{
    use \App\Models\Audit\MedusaAudit;

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
            json_encode(['billet_name' => 'Fleet CO Liaison']),
            'add_flag_lt'
        );
        App\Models\Billet::create(['billet_name' => 'Fleet CO Liaison']);
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
