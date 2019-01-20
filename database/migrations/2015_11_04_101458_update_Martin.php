<?php

use Illuminate\Database\Migrations\Migration;

class UpdateMartin extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = App\User::where('member_id', '=', 'RMN-0001-07')->first();

        $user->registration_date = '2007-02-01';

        $this->writeAuditTrail(
            'system user',
            'update',
            'users',
            $user->id,
            $user->toJson(),
            'fix_secondary_assignments'
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
