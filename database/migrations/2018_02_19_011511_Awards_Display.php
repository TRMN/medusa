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
        \App\Models\MedusaConfig::set(
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
        \App\Models\MedusaConfig::remove('awards.display');
    }
}
