<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Grade Model.
 *
 * Pay Grades and descriptions
 */
class Grade extends Eloquent
{
    /**
     * @var array Fields that can be set
     */
    protected $fillable = ['grade', 'rank'];

    private static $gradeFilters = [
        'E' => 'Enlisted',
        'W' => 'Warrant Officer',
        'O' => 'Officer',
        'F' => 'Flag Officer',
        'C' => 'Civilian',
    ];

    public static function getRequirements($paygrade2check)
    {
        $requirements = Medusaconfig('pp.requirements');

        return $requirements[$paygrade2check];
    }

    public static function getRankTitle($grade, $rate = null, $branch = 'RMN')
    {
        $gradeDetails = self::where('grade', '=', $grade)->first();

        $rateDetail = Rating::where('rate_code', '=', $rate)->first();

        if (empty($gradeDetails->rank[$branch]) === false) {
            $rank_title = self::mb_trim($gradeDetails->rank[$branch]);
        } else {
            $rank_title = $grade;
        }

        if (empty($rateDetail->rate[$branch][$grade]) === false) {
            $rank_title = $rateDetail->rate[$branch][$grade];
        }

        return $rank_title;
    }

    /**
     * Get the paygrades for a branch.
     *
     * @param $branchID
     * @param null $filter Valid values are null, E, O, F, W and C
     *
     * @return array
     */
    public static function getGradesForBranch($branchID)
    {
        //$grades[''] = 'Select a rank';

        foreach (self::$gradeFilters as $filter => $filterName) {
            $tmp = self::_gradesForBranchForSelect($branchID, $filter);

            if (empty($tmp) === false) {
                $grades[$filterName] = $tmp;
            }
        }

        return $grades;
    }

    private static function _gradesForBranchForSelect($branchID, $filter)
    {
        $grades = [];

        foreach (self::_gradesForBranch($branchID, $filter) as $grade) {
            $grades[$grade->grade] = self::mb_trim($grade->rank[$branchID]).' ('.$grade->grade.')';
        }

        // Sort by the array key, which is the paygrade
        ksort($grades, SORT_NATURAL);

        return $grades;
    }

    /**
     * Helper method to return an array of pay grades, optionally filter by Enlisted, Officer, Flag Officer, Warrant
     * Officer or Civilian.
     *
     * @param $branchID
     * @param null $filter Valid values are null, E, O, F, W and C
     *
     * @return array
     */
    private static function _gradesForBranch($branchID, $filter = null)
    {
        $grades = [];

        $paygrades = self::_filterGrades($filter);

        foreach ($paygrades as $grade) {
            if (empty($grade->rank[$branchID]) === false) {
                $grades[] = $grade;
            }
        }

        return $grades;
    }

    /**
     * Helper method to filter paygrades by Enlisted, Officer, Flag Officer, Warrant Officer, Civilian or all
     * paygrades (null).
     *
     * @param null $filter Valid values are null, E, O, F, W and C
     *
     * @return array
     */
    private static function _filterGrades($filter = null)
    {
        $grades = [];

        // If $filter is set, validate it

        if (is_null($filter) === false && in_array($filter, ['E', 'O', 'F', 'W', 'C']) === false) {
            $filter = null;
        }

        foreach (self::all() as $grade) {
            if (self::_filterMatch($filter, $grade->grade) === true) {
                $grades[] = $grade;
            }
        }

        return $grades;
    }

    /**
     * Helper method to return T/F if a paygrade matches the filter.
     *
     * @param $filter
     * @param $grade
     *
     * @return bool
     */
    private static function _filterMatch($filter, $grade)
    {
        return is_null($filter) === true ? true : substr($grade, 0, 1) === $filter;
    }

    /**
     * Trim whitespace from mb_strings.
     *
     * @param $string
     * @param string $trim_chars
     *
     * @return mixed
     */
    private static function mb_trim($string, $trim_chars = '\s')
    {
        return preg_replace('/^['.$trim_chars.']*(?U)(.*)['.$trim_chars.']*$/u', '\\1', $string);
    }

    /**
     * Shortcut method to get enlisted paygrades.
     *
     * @return array
     */
    public static function enlistedPayGrades()
    {
        return self::_filterGrades('E');
    }

    /**
     * Shortcut method to get warrant officer paygrades.
     *
     * @return array
     */
    public static function warrantPayGrades()
    {
        return self::_filterGrades('W');
    }

    /**
     * Shortcut method to get officer paygrades.
     *
     * @return array
     */
    public static function officerPayGrades()
    {
        return self::_filterGrades('O');
    }

    /**
     * Shortcut method to get flag officer paygrades.
     *
     * @return array
     */
    public static function flagPayGrades()
    {
        return self::_filterGrades('F');
    }

    /**
     * Shortcut method to get civilian paygrades.
     *
     * @return array
     */
    public static function civilianPayGrades()
    {
        return self::_filterGrades('C');
    }
}
