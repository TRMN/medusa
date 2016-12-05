<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEmptyAssignments extends Migration
{

    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::where('registration_status', '=', 'Pending')->get();

        $hmssGreenwich = Chapter::where('hull_number', '=', 'SS-001')->first();

        $assignment[] = [
            'chapter_id'    => $hmssGreenwich->id,
            'chapter_name'  => $hmssGreenwich->chapter_name,
            'date_assigned' => date('Y-m-d'),
            'billet'        => 'Crewman',
            'primary'       => true,
        ];

        foreach ($users as $user) {
            if (count($user->assignment) === 0) {
                // Pending application with no assignment information
                $user->assignment = $assignment;

                $this->writeAuditTrail(
                    'system user',
                    'update',
                    'users',
                    $user->id,
                    $user->toJson(),
                    'fix_empty_assignments'
                );

                $user->save();
            }
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
