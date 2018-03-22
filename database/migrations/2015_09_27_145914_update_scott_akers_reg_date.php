<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateScottAkersRegDate extends Migration
{

    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = App\User::where('member_id', '=', 'RMN-0011-08')->first();

        $user->registration_date = "2008-02-22";
        $user->application_date = "2008-02-22";

        $this->writeAuditTrail(
            'system user',
            'update',
            'users',
            $user->id,
            $user->toJson(),
            'update_scott_akers_reg_date'
        );

        $user->save();
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
