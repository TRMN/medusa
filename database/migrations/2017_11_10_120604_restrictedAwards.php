<?php

use Illuminate\Database\Migrations\Migration;

class RestrictedAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = ['OSWP', 'ESWP', 'MCAM', 'KR3CM', 'QE3CM', 'QE3GJM', 'QE3SJM'];

        \App\Models\MedusaConfig::set('awards.restricted', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\MedusaConfig::remove('awards.restricted');
    }
}
