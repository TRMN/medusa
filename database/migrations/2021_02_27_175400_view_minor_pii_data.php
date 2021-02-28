<?php

use App\MedusaConfig;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewMinorPiiData extends Migration
{
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

        MedusaConfig::set('minor_pii_config', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	MedusaConfig::remove('minor_pii_config');
    }
}
