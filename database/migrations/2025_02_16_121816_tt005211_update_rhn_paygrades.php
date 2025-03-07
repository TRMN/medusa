<?php

use App\Grade;
use Illuminate\Database\Migrations\Migration;

class TT005211UpdateRhnPaygrades extends Migration
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
        $branch = 'RHN';
        $paygrades = [
            'E-10' => 'Senior Master Chief Petty Officer',
            // 'F-6' => 'Chief of Naval Operations',
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
        // Restore the saved copy
        //MedusaConfig::set('pp.requirements', MedusaConfig::get('pp.requirements.bak'));

        // Delete the backup and the new entries
        // MedusaConfig::remove('pp.requirements.bak');
    }
}
