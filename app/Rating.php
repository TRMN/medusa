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

    protected $fillable = [ 'rate_code', 'rate' ];

    static function getRatingsForBranch($branchID)
    {
        $results = Rating::all();
        $ratings = [];

        foreach ($results as $rating) {
            if (isset($rating->rate[$branchID]) == true && empty($rating->rate[$branchID]) === false) {
                $ratings[$rating->rate_code] = $rating->rate['description'] . ' (' . $rating->rate_code . ')';
            }
        }

        asort($ratings, SORT_NATURAL);

        if (count($ratings) > 0) {
            $ratings = ['' => 'Select a Rating'] + $ratings;
        } else {
            $ratings = ['' => 'No ratings available for this branch'];
        }

        return $ratings;
    }
}
