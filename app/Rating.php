<?php

/**
 * Rating Model
 *
 * Enlisted Ratings
 */

use Jenssegers\Mongodb\Model as Eloquent;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
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
