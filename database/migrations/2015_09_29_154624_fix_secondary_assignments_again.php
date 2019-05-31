<?php

use Illuminate\Database\Migrations\Migration;

class FixSecondaryAssignmentsAgain extends Migration
{
    use \App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = App\Models\User::all();

        foreach ($users as $user) {
            $assignments = [];

            foreach ($user->assignment as $assignment) {
                if (empty($assignment['scondary']) === true) {
                    $assignments[] = $assignment; // Don't need to do anything
                } else {
                    // Let's spell secondary correct this time, shall we?

                    unset($assignment['scondary']);
                    $assignment['secondary'] = true;
                    $assignments[] = $assignment;
                }
            }

            $user->assignment = $assignments;

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
