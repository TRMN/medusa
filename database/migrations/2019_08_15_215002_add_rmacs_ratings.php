<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRmacsRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (['SRN-13', 'SRN-05', 'SRN-11', 'SRN-12', 'SRN-32', 'SRN-10'] as $rate_code) {
            $rating = \App\Rating::where('rate_code', $rate_code)->first();
            $rmacs = [];
            $oldPayGrade = null;
            $ratings = $rating->rate;
            foreach ($ratings['RMN'] as $payGrade => $rankTitle) {
                $user = new \App\User();
                $user->rank = [
                    'grade' => $payGrade,
                ];
                $user->branch = 'RMN';
                $user->rating = null;

                $newPayGrade = \App\Grade::getPayGradeEquiv($user, 'RMACS');
                if ($newPayGrade !== $oldPayGrade) {
                    $oldPayGrade = $newPayGrade;
                    $rmacs[$newPayGrade] = $rankTitle;
                }
            }
            $ratings['RMACS'] = $rmacs;
            $rating->rate = $ratings;
            $rating->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (['SRN-13', 'SRN-05', 'SRN-11', 'SRN-12', 'SRN-32', 'SRN-10'] as $rate_code) {
            \App\Rating::where('rate_code', $rate_code)->delete();
        }
    }
}
