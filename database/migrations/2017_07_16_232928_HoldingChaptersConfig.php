<?php

use Illuminate\Database\Migrations\Migration;

class HoldingChaptersConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $holding = ['SS-001', 'SS-002', 'RMOP-01', 'HC', 'RHSS-01', 'SMRS-01'];

        App\MedusaConfig::set('chapter.holding', $holding);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        App\MedusaConfig::remove('chapter.holding');
    }
}
