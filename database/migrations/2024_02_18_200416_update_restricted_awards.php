<?php

use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRestrictedAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Get the current set of restricted awards.
        $awards = MedusaConfig::get('awards.restricted');

        // Save a backup to be used by the rollback
        MedusaConfig::set('awards.restricted.bak', $awards);

        // Add the Queen Elizabeth III Diamond Jubilee Medal and the
        // Yawata Strike Memorial Ribbon
        $awards = array_merge($awards, ['QE3DJM', 'YSMR']);

        // Update the current settings
        MedusaConfig::set('awards.restricted', $awards);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reset the restricted awards from the backup.
        MedusaConfig::set('awards.restricted', MedusaConfig::get('awards.restricted.bak'));
        MedusaConfig::remove('awards.restricted.bak');
    }
}
