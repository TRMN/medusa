<?php

use Illuminate\Database\Migrations\Migration;

class SWPandMCAMcheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     * {@inheritdoc}
     */
    public function up()
    {
        foreach (\App\Models\User::activeUsers() as $user) {
            // Check for SWP qualification.  This is for existing SWP's that may
            // not be recorded, so set isNewAward to false.  Check for SWP first,
            // because you can get a MCAM unless you have a SWP
            $user->swpQual(false);

            // Check for 1 or more MCAM's.  Again, this is for existing MCAM's
            // that may not be recorded, so set isNewAward to false.
            $user->mcamQual(false);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // There is no roll back of data for this migration.
    }
}
