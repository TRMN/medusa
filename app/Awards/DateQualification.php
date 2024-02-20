<?php

namespace App\Awards;

use App\Audit\MedusaAudit;
use App\User;
use http\Exception\InvalidArgumentException;

/**
 * Trait DateQualification.
 */
trait DateQualification
{
    use MedusaAudit;

    /**
     * Check if a member qualifies for a date limited award.  A start or end date is required.  If both are empty,
     * an error is thrown.
     *
     * @param \App\User $user
     *  The user object.
     * @param $award_code
     *  The code for the award.  I.e, QE3CM.
     * @param $start_date
     *  The start date of the qualification period.  Set to null or an empty string to set this to a year before the
     *  end date.
     * @param $end_date
     *  The end date of the qualification period.  Set to null or an empty string to set this to a year after the start
     *  date.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function checkAwardDateQualification(User $user, $award_code, $start_date = null, $end_date = null)
    {
        // Throw an error exception if both start and end date are empty.
        if (empty($start_date) === true && empty($end_date) === true) {
            throw new \InvalidArgumentException('You must provide a start date, end date, or both');
        }

        // Make sure the start date and end date are unix timestamps if they are set.
        if (is_int($start_date) === false && empty($start_date) === false) {
            $start_date = strtotime($start_date);
        }

        if (is_int($end_date) === false && empty($end_date) === false) {
            $end_date = strtotime($end_date);
        }

        // If there is a start date, the award date is the start date.
        if (empty($start_date) === false) {
            $awardDate = $start_date;
        }

        // If there is no end date, set the end date to 1 year after the start date.
        if (empty($end_date) === true) {
            $end_date = strtotime('+1 year', $start_date);
        }

        // If there is no start date, the start date is 1 year before the end date, as is the award date.
        if (empty($start_date) === true) {
            $start_date = $awardDate = strtotime('-1 year', $end_date);
        }

        // Check that the start date is not greater than the end date
        if ($start_date > $end_date) {
            throw new \InvalidArgumentException('The start date must earlier than the end date');
        }

        // Qualification checks.
        $endDateCheck = strtotime($user->registration_date) < $end_date;
        $startDateCheck = time() > $start_date;

        if ($user->hasAward($award_code) === false &&
            $user->registration_status === 'Active' && $endDateCheck === true && $startDateCheck === true) {
            // The user does not have the award and qualifies, add it
            $awards = $user->awards;

            $awards[$award_code] = [
                'count' => 1,
                'location' => 'L',
                'display' => true,
                'award_date' => [date('Y-m-d', $awardDate)],
            ];

            $user->awards = $awards;
            $user->save();

            $this->writeAuditTrail(\Auth::user()->member_id, 'Update', 'user', $user->id, $user->toJson(), 'coronationAndJubilee');
        }
    }
}
