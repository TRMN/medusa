<?php

use Illuminate\Database\Migrations\Migration;

class SetAssignmentDates extends Migration
{
    use App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        App\Models\User::unguard();

        $members = App\Models\User::where('active', '=', 1)->where('registration_status', '=', 'Active')->get();

        $july31 = strtotime('2015-07-31');

        foreach ($members as $member) {
            $assignments = $member->assignment;
            $newAssignments = [];
            foreach ($assignments as $assignment) {
                if (empty($assignment['date_assigned']) === true) {
                    if (strtotime($member->registration_date) > $july31) {
                        $assignment['date_assigned'] = $member->registration_date;
                    } else {
                        $assignment['date_assigned'] = '2015-07-31';
                    }
                }
                $newAssignments[] = $assignment;
            }

            $member->assignment = $newAssignments;

            $this->writeAuditTrail(
                'system user',
                'update',
                'users',
                $member->id,
                $member->toJson(),
                'set_assignemnt_dates'
            );

            $member->save();
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
