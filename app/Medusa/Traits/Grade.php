<?php


namespace Medusa\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;

trait Grade
{
    /**
     * @var array Fields that can be set
     */
    protected $fillable = ['grade', 'rank'];

    /**
     * If your organization does not use these designations, you will
     * have to add this static to your model.
     *
     * @var array Grade prefixes and names
     */
    private static $gradeFilters = [
        'E' => 'Enlisted',
        'W' => 'Warrant Officer',
        'O' => 'Officer',
        'F' => 'Flag Officer',
        'C' => 'Civilian',
    ];

    /**
     * Get the paygrades for a branch.
     *
     * @param $branchID
     *
     * @return array
     */
    public static function getGradesForBranch($branchID)
    {

        foreach (self::$gradeFilters as $filter => $filterName) {
            $tmp = self::gradesForBranchForSelect($branchID, $filter);

            if (empty($tmp) === false) {
                $grades[$filterName] = $tmp;
            }
        }

        return $grades;
    }

    /**
     * Get a list of pay grades and their titles suitable for creating an HTML select.
     *
     * {@inheritdoc} self::gradesForBranch
     *
     * @param $branchID
     * @param $filter
     *
     * @return array
     */
    private static function gradesForBranchForSelect($branchID, $filter)
    {
        $grades = [];

        foreach (self::gradesForBranch($branchID, $filter) as $grade) {
            $grades[$grade->grade] = self::mbTrim($grade->rank[$branchID]).' ('.$grade->grade.')';
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
     * @param null $filter
     *
     * @return array
     */
    private static function gradesForBranch($branchID, $filter = null)
    {
        $grades = [];

        $paygrades = self::filterGrades($filter);

        foreach ($paygrades as $grade) {
            if (empty($grade->rank[$branchID]) === false) {
                $grades[] = $grade;
            }
        }

        return $grades;
    }

    /**
     * Helper method to filter paygrades.
     *
     * @param null $filter
     *
     * @return array
     */
    private static function filterGrades($filter = null)
    {
        $grades = [];

        // If $filter is set, validate it

        if (is_null($filter) === false && in_array($filter, self::$gradeFilters) === false) {
            $filter = null;
        }

        foreach (self::all() as $grade) {
            if (self::filterMatch($filter, $grade->grade) === true) {
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
    private static function filterMatch($filter, $grade)
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
    private static function mbTrim($string, $trim_chars = '\s')
    {
        return preg_replace('/^['.$trim_chars.']*(?U)(.*)['.$trim_chars.']*$/u', '\\1', $string);
    }

    /**
     * Check if the requested pay grade is valid for the specified branch.
     *
     * @param $paygrade
     * @param $branch
     *
     * @return bool
     */
    public static function isPayGradeValidForBranch($paygrade, $branch)
    {
        try {
            $gradeInfo = self::where('grade', $paygrade)->firstOrFail();

            return isset($gradeInfo->rank[$branch]);
        } catch (ModelNotFoundException $e) {
            // Paygrade doesn't exist
            return false;
        }
    }
}