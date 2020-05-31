<?php

use Illuminate\Database\Migrations\Migration;

class NormalizeEmail extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = \App\User::all();

        foreach ($users as $user) {
            $user->email_address = strtolower($user->email_address);

            $this->writeAuditTrail(
                'system user',
                'update',
                'users',
                (string) $user->_id,
                $user->toJson(),
                'normalize email addresses'
            );

            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
