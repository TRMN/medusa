<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTriadReportPermission extends Migration {

    use \Medusa\Audit\MedusaAudit;

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
            'permissions',
            null,
            json_encode(["name" => "TRIAD_REPORT", "description" => "Download Command Triad Report"]),
            'add_triad_report_perm'
        );
        Permission::create(["name" => "TRIAD_REPORT", "description" => "Download Command Triad Report"]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
