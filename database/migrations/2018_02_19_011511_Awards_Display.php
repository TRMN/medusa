<?php

use Illuminate\Database\Migrations\Migration;

class AwardsDisplay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\MedusaConfig::set(
            'awards.display',
            [
                'OSWP',
                'ESWP',
                'SAW',
                'EAW',
                'OAW',
                'ESAW',
                'OSAW',
                'EMAW',
                'OMAW',
                'ENW',
                'ONW',
                'ESNW',
                'OSNW',
                'EMNW',
                'OMNW',
                'EOW',
                'OOW',
                'ESOW',
                'OSOW',
                'EMOW',
                'OMOW',
                'ESW',
                'OSW',
                'ESSW',
                'OSSW',
                'EMSW',
                'OMSW',
                'HS',
                'CIB',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('awards.display');
    }
}
