<?php

use App\Audit\MedusaAudit;
use App\MedusaConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MaxPwdAge extends Migration
{
    use MedusaAudit;

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
            'config',
            null,
            json_encode(['name' => 'config.max_pwd_age']),
            'add_new_config'
        );

        MedusaConfig::set('config.max_pwd_age', 30);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->writeAuditTrail(
            'system user',
            'delete',
            'config',
            null,
            json_encode(['name' => 'config.max_pwd_age']),
            'remove_new_config'
        );

        MedusaConfig::remove('config.max_pwd_age');
    }
}
