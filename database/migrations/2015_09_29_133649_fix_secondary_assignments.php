<?php

use Illuminate\Database\Migrations\Migration;

class FixSecondaryAssignments extends Migration
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
            $foundSecondary = false;
            $foundAdditional = false;

            foreach ($user->assignment as $assignment) {
                if (empty($assignment['primary']) === false && $assignment['primary'] === true) {
                    $assignments[] = $assignment; // Don't need to do anything
                } else {
                    if ($foundSecondary === false) {
                        // Not the primary, set it to secondary
                        unset($assignment['primary']);
                        $assignment['scondary'] = true;
                        $assignments[] = $assignment;
                        $foundSecondary = true;
                    } else {
                        unset($assignment['primary']);
                        $assignment['additional'] = true;
                        $assignments[] = $assignment;
                        $foundAdditional = true;
                    }
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
