<?php

/**
 * Grade Model
 *
 * Pay Grades and descriptions
 */
class Grade extends Moloquent
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
