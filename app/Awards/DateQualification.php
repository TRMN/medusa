<?php
namespace App\Awards;

use App\Audit\MedusaAudit;

/**
 * Trait DateQualification
 * @package App\Awards
 *
 * Date based award functions
 *
 */

trait DateQualification
{
    use MedusaAudit;

    public function coronationAndJubilee(\App\User $user, $award, $date)
    {
        if (is_int($date) === false) {
            $date = strtotime($date);
        }

        if ($user->hasAward($award) === false &&
            $user->registration_status === 'Active' &&
            strtotime($user->registration_date) < $date && time() > strtotime('-1 year', $date)) {
            // The user does not have the award and qualifies, add it

            $awards = $user->awards;

            $awards[$award] = [
                'count' => 1,
                'location' => 'L',
                'display' => true,
                'award_date' => [date('Y-m-d', strtotime('-1 year', $date))],
            ];

            $user->awards = $awards;

            $user->save();

            $this->writeAuditTrail(\Auth::user()->member_id, 'Update', 'user', $user->id, $user->toJson(), 'coronationAndJubilee');
        }
    }
}