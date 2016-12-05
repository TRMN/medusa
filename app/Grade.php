<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Grade Model
 *
 * Pay Grades and descriptions
 */



class Grade extends Model
{

    protected $fillable = [ 'grade', 'rank' ];

    static function getGradesForBranch($branchID)
    {
        $results = Grade::all();
        $grades[''] = "Select a Rank";

        foreach ($results as $grade) {
            if (empty($grade->rank[$branchID]) === false) {
                $grades[$grade->grade] = $grade->rank[$branchID] . ' (' . $grade->grade . ')';
            }
        }
        ksort($grades, SORT_NATURAL);

        return $grades;
    }
}
