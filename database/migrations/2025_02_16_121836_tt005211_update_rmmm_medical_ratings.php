<?php

use App\Rating;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmMedicalRatings extends Migration
{
    use \App\Audit\MedusaAudit;
    
    /**
     * @param string $ratecode
     * @param string $branch
     * @param array $new_ratings
     * @return void
     */
    public function update_ratings(string $ratecode, string $branch, array $new_ratings)
    {
        $record = Rating::where('rate_code', $ratecode)->first();
        $ratings = $record->rate;

        foreach ($new_ratings as $paygrade => $title) {
            if (is_null($title)) {
                unset($ratings[$branch][$paygrade]);
            } else {
                $ratings[$branch][$paygrade] = $title;
            }
        }

        $record->rate = $ratings;

        $this->writeAuditTrail(
            'system user',
            'update',
            'ratings',
            $record->id,
            $record->toJson(),
            'update_rating_titles'
        );

        $record->save();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rate_code = 'MEDICAL';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Medical Aide',
            'C-4' => 'Medical Assistant',
            'C-5' => 'Medical Technician',
            'C-6' => 'Paramedic',
            'C-7' => 'Sick Berth Attendant',
            'C-8' => 'Senior Sick Berth Attendant',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Nursing Assistant',
            'C-12' => 'Nurse',
            'C-13' => 'Senior Nurse',
            'C-14' => 'Practical Nurse',
            'C-15' => 'Assistant Merchant Surgeon',
            'C-16' => 'Merchant Surgeon',
            'C-17' => 'Fleet Medical Director',
            'C-18' => 'Superintendent',
            'C-19' => 'Managing Director',
            'C-20' => 'Owner',
            'C-21' => 'Board Director',
            'C-22' => 'Home Secretary',
            'C-23' => null,
        ];

        $this->update_ratings($rate_code, 'RMMM', $ratings);
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
