<?php

use App\Rating;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmCateringRatings extends Migration
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
        $rate_code = 'CATERING';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Steward Assistant',
            'C-4' => 'Second Cook',
            'C-5' => 'Steward',
            'C-6' => 'Baker',
            'C-7' => 'Chief Cook',
            'C-8' => 'Chief Steward',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Junior Assistant Purser',
            'C-12' => 'Junior Purser',
            'C-13' => 'Purser',
            'C-14' => 'Entertainment Director',
            'C-15' => 'Cruise Director',
            'C-16' => 'Hotel Manager',
            'C-17' => 'Fleet Passenger Director',
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
