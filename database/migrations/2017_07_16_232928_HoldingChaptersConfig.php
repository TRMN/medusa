<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
Use App\MedusaConfig;

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

        MedusaConfig::set('chapter.holding', $holding);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MedusaConfig::remove('chapter.holding');
    }
}
