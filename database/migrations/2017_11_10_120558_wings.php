<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = [
            "Aerospace Wings" => [
                "EAW",
                "OAW",
                "ESAW",
                "OSAW",
                "EMAW",
                "OMAW"
            ],
            "Navigator Wings" => [
                "ENW",
                "ONW",
                "ESNW",
                "OSNW",
                "EMNW",
                "OMNW"
            ],
            "Observer Wings" => [
                "EOW",
                "OOW",
                "ESOW",
                "OSOW",
                "EMOW",
                "OMOW"
            ],
            "Simulator Wings" => [
                "ESW",
                "OSW",
                "ESSW",
                "OSSW",
                "EMSW",
                "OMSW"
            ]
        ];

        \App\MedusaConfig::set('awards.wings', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('awards.wings');
    }
}
