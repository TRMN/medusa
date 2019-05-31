<?php

use Illuminate\Database\Migrations\Migration;

class AddFlagLt extends Migration
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
            'billets',
            null,
            json_encode(['billet_name' => 'Flag Lieutenant']),
            'add_flag_lt'
        );
        App\Billet::create(['billet_name' => 'Flag Lieutenant']);
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
