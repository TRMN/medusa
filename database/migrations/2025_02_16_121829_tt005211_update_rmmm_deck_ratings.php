<?php

use App\Rating;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmDeckRatings extends Migration
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
        $rate_code = 'DECK';
        $ratings = [
            'C-1' => 'Apprentice Spacer',
            'C-2' => 'General Vessel Assistant',
            'C-3' => 'Ordinary Spacer',
            'C-4' => 'Senior Ordinary Spacer',
            'C-5' => 'Efficient Spacer',
            'C-6' => 'Able Spacer',
            'C-7' => 'Leading Spacer',
            'C-8' => 'Certified Bosun',
            'C-9' => 'Patrolman',
            'C-10' => 'President',
            'C-11' => 'Fourth Officer',
            'C-12' => 'Third Officer',
            'C-13' => 'Second Officer',
            'C-14' => 'Senior Second Officer',
            'C-15' => 'First Officer',
            'C-16' => 'Master',
            'C-17' => 'Fleet Manager',
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
