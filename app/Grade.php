<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $requirements = MedusaConfig::get('pp.requirements');

        return $requirements[$paygrade2check];
    }

    public static function getRankTitle($grade, $rate = null, $branch = 'RMN')
    {
        if (is_null($rate) === true && $branch == 'CIVIL') {
            $rate = 'DIPLOMATIC';
        }
        $gradeDetails = self::where('grade', '=', $grade)->first();

        $rateDetail = Rating::where('rate_code', '=', $rate)->first();

        if (empty($gradeDetails->rank[$branch]) === false) {
            $rank_title = self::mbTrim($gradeDetails->rank[$branch]);
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
            $grades[$grade->grade] = self::mbTrim($grade->rank[$branchID]) . ' (' . $grade->grade . ')';
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
     * Helper method to filter paygrades by Enlisted, Officer, Flag Officer, Warrant Officer, Civilian or all
     * paygrades (null).
     *
     * @param null $filter Valid values are null, E, O, F, W and C
     *
     * @return array
     */
    private static function filterGrades($filter = null)
    {
        $grades = [];

        // If $filter is set, validate it

        if (is_null($filter) === false && in_array($filter, ['E', 'O', 'F', 'W', 'C']) === false) {
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
        return preg_replace('/^[' . $trim_chars . ']*(?U)(.*)[' . $trim_chars . ']*$/u', '\\1', $string);
    }

    /**
     * Shortcut method to get enlisted paygrades.
     *
     * @return array
     */
    public static function enlistedPayGrades()
    {
        return self::filterGrades('E');
    }

    /**
     * Shortcut method to get warrant officer paygrades.
     *
     * @return array
     */
    public static function warrantPayGrades()
    {
        return self::filterGrades('W');
    }

    /**
     * Shortcut method to get officer paygrades.
     *
     * @return array
     */
    public static function officerPayGrades()
    {
        return self::filterGrades('O');
    }

    /**
     * Shortcut method to get flag officer paygrades.
     *
     * @return array
     */
    public static function flagPayGrades()
    {
        return self::filterGrades('F');
    }

    /**
     * Shortcut method to get civilian paygrades.
     *
     * @return array
     */
    public static function civilianPayGrades()
    {
        return self::filterGrades('C');
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

    /**
     * Get the equivalent paygrade for the specified branch
     *
     * @param \App\User $user
     * @param $newBranch
     *
     * @return string|false
     */
    public static function getPayGradeEquiv(User $user, $newBranch)
    {
        $rankEquivChart = MedusaConfig::get('rank.equiv');

        $payGrade = $user->getPayGrade();
        $rate = $user->getRate();

        $branchToCheck = $user->branch;

        // Special handling for civilian and merchant marine
        switch ($user->branch) {
            case 'CIVIL':
                // Rating is required.  If not rating present, the default is 'DIPLOMATIC'
                $branchToCheck = $rate;
                break;
            case 'RMMM':
                // RMMM requires a rating a higher levels
                if (is_null($rate) === false) {
                    $branchToCheck = $rate;
                }
                break;
        }

        foreach ($rankEquivChart as $row) {
            if ($row[$branchToCheck] == $payGrade) {
                return $row[$newBranch];
            }
        }
        return false;
    }

    /**
     * Get a members new paygrade, taking into account possible military->civilian->military branch changes. By default
     * it will update the members record to record the their current military rank for military->civilian changes or
     * removing the record of their old
     *
     * @param \App\User $user
     * @param \App\Branch $oldBranch
     * @param \App\Branch $newBranch
     * @param bool $updateUser
     *
     * @return string
     */
    public static function getNewPayGrade(User $user, Branch $oldBranch, Branch $newBranch, $updateUser = true)
    {
        if ($oldBranch->isMilitaryBranch() === true &&
            $newBranch->isCivilianBranch() === true) {
            if ($updateUser === true) {
                // Transferring from military to civilian, save their current branch and rank
                $user->previous = [
                    'branch'    => $user->branch,
                    'pay_grade' => $user->rank['grade'],
                ];

                $user->save();
            }
            return self::getPayGradeEquiv($user, $newBranch->branch);
        }

        if ($oldBranch->isCivilianBranch() === true &&
            $newBranch->isMilitaryBranch() === true &&
            isset($user->previous) === true) {
            if ($updateUser === true) {
                // Whack the previous property since they're transferring back to a military branch
                $user->previous = [];

                $user->save();
            }

            // Transferring from civilian to military, and they were previously military.  Check if their
            // current civilian rank is a match for their old military rank.  If it is, use that to find
            // the new rank for the new branch, which might be the same as their last branch before this.

            $userCopy = clone $user;
            $userCopy->branch = $user->previous['branch'];
            $userCopy->rank = [
                'date_of_rank' => $user->rank['date_of_rank'],
                'grade'        => $user->previous['pay_grade'],
            ];

            // Check to see if they've been promoted as a civilian to a pay-grade that has a higher equivalency
            // This is done by getting the pay grade equivalent for their current branch using their old rank
            // and branch
            if ($user->previous['pay_grade'] === self::getPayGradeEquiv($userCopy, $oldBranch->branch)) {
                // Previous rank converts to their current civilian rank, so use the previous rank for
                // the new rank lookup
                return Grade::getPayGradeEquiv($userCopy, $newBranch->branch);
            }
        }
        return self::getPayGradeEquiv($user, $newBranch->branch);
    }
}
