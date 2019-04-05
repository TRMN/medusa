<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Rating Model.
 *
 * Enlisted Ratings
 */
class Rating extends Eloquent
{
    protected $fillable = ['rate_code', 'rate'];

    public static function getRatingsForBranch($branchID)
    {
        $results = self::all();
        $ratings = [];

        foreach ($results as $rating) {
            if (isset($rating->rate[$branchID]) == true &&
                empty($rating->rate[$branchID]) === false) {
                $ratings[$rating->rate_code] =
                    $rating->rate['description'].' ('.$rating->rate_code.')';
            }
        }

        asort($ratings, SORT_NATURAL);

        if (count($ratings) > 0) {
            switch ($branchID) {
                case 'RMMM':
                    $ratings = ['' => 'Select a Division'] + $ratings;
                    break;
                case 'CIVIL':
                    $ratings = ['' => 'Select a Speciality'] + $ratings;
                    break;
                default:
                    $ratings = ['' => 'Select a Rating'] + $ratings;
            }
        } else {
            $ratings = ['' => 'No ratings available for this branch'];
        }

        return $ratings;
    }

    public static function getRateName(
        $rateCode
    ) {
        $rating = self::where('rate_code', '=', $rateCode)->first();

        return $rating->rate['description'];
    }

    /**
     * Is the pay grade specified valid for the branch and rating provided
     *
     * @param $branch
     * @param $rating
     * @param $paygrade
     *
     * @return bool
     */
    public static function isPayGradeValid($paygrade, $branch, $rating)
    {
        try {
            $rateInfo = Rating::where('rate_code', $rating)->firstOrFail();

            return isset($rateInfo->rate[$branch][$paygrade]);
        } catch (ModelNotFoundException $e) {
            // Rating doesn't exist
            return false;
        }
    }
}
