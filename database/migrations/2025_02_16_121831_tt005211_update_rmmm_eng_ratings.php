<?php

use App\Rating;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmEngRatings extends Migration
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
        $rate_code = 'ENG';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Wiper',
            'C-4' => 'Technician',
            'C-5' => 'Technician II',
            'C-6' => 'Technician III',
            'C-7' => 'Technician IV',
            'C-8' => 'Technician V',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Fourth Engineer',
            'C-12' => 'Third Engineer',
            'C-13' => 'Second Engineer',
            'C-14' => 'Senior Second Engineer',
            'C-15' => 'First Engineer',
            'C-16' => 'Chief Engineer',
            'C-17' => 'Fleet Port Manager',
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
