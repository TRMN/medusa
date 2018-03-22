<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFleetCoAndDco extends Migration
{

    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $billets = ['Fleet Commander', 'Deputy Fleet Commander', 'Fleet Bosun'];

        foreach ($billets as $billet) {
            $this->writeAuditTrail(
                'system user',
                'create',
                'billets',
                null,
                json_encode(["billet_name" => $billet]),
                'add_fleet_co_and_dco'
            );
            App\Billet::create(["billet_name" => $billet]);
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
