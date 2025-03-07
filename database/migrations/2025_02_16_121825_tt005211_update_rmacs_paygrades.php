<?php

use App\Grade;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmacsPaygrades extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * @param string $branch
     * @param array $paygrades
     * @return void
     */
    public function update_paygrades(string $branch, array $paygrades)
    {
        foreach ($paygrades as $paygrade => $title) {
            $record = Grade::where('grade', $paygrade)->first();
            $ranks = $record->rank;
            if (is_null($title)) {
                unset($ranks[$branch]);
            } else {
                $ranks[$branch] = $title;
            }

            $record->rank = $ranks;

            $this->writeAuditTrail(
                'system user',
                'update',
                'grades',
                $record->id,
                $record->toJson(),
                'update_rank_titles'
            );

            $record->save();
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $branch = 'RMACS';
        $paygrades = [
            'C-1' => 'Recruit',
            'C-2' => 'Trainee',
            'C-3' => 'Candidate',
            'C-4' => 'Petty Officer Third Class',
            'C-5' => 'Petty Officer Second Class',
            'C-6' => 'Petty Officer First Class',
            'C-7' => 'Chief Petty Officer',
            'C-8' => 'Senior Chief Petty Officer',
            'C-9' => 'Master Chief Petty Officer',
            'C-10' => 'Senior Master Chief Petty Officer',
            'C-11' => 'Ensign',
            'C-12' => 'Lieutenant (JG)',
            'C-13' => 'Lieutenant (SG)',
            'C-14' => 'Lieutenant Commander',
            'C-15' => 'Commander',
            'C-16' => 'Captain',
            'C-17' => 'Commodore',
            'C-18' => 'Rear Admiral',
            'C-19' => 'Vice Admiral',
            'C-20' => 'Admiral',
            'C-21' => 'Transport Minister',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_paygrades($branch, $paygrades);
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
