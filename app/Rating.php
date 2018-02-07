<?php

namespace App;

use Moloquent\Eloquent\Model as Eloquent;

/**
 * Rating Model
 *
 * Enlisted Ratings
 */
class Rating extends Eloquent
{

    protected $fillable = ['rate_code', 'rate'];

    public static function getRatingsForBranch($branchID)
    {
        $results = Rating::all();
        $ratings = [];

        foreach ($results as $rating) {
            if (isset($rating->rate[$branchID]) == true &&
                empty($rating->rate[$branchID]) === false) {
                $ratings[$rating->rate_code] =
                    $rating->rate['description'] . ' (' . $rating->rate_code . ')';
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
}
