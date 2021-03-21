<?php

use App\MedusaConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewMinorPiiData extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	$config = [
	    'default' => 18,
	    'data' => [
	        [
		    'field' => 'state_province',
		    'value' => 'AL',
		    'age' => 19
		],
	        [
		    'field' => 'state_province',
		    'value' => 'NE',
		    'age' => 19
		],
	        [
		    'field' => 'state_province',
		    'value' => 'MS',
		    'age' => 21
		]
	    ]
	];

        $this->writeAuditTrail(
            'system user',
            'create',
            'config',
            null,
            json_encode(['name' => 'minor_pii_config']),
            'add_new_config'
        );

        MedusaConfig::set('minor_pii_config', $config);
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
            json_encode(['name' => 'minor_pii_config']),
            'remove_new_config'
        );

        MedusaConfig::remove('minor_pii_config');
    }
}
