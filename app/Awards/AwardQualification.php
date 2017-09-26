<?php

namespace App\Awards;

use App\User;

/**
 * Trait AwardQualification
 *
 * @package App\Awards
 *
 * Functions to check various award qualifications
 */
trait AwardQualification
{
    public function mcamQual(User $user)
    {
        $numMCAM = 0;

        if ($user->hasAward('ESWP') === true || $user->hasAward('OSWP') === true) {
            // If they're not qualified for a SWP, they can't qual for a MCAM

            $numExams = count($user->getExamList());


            if ($numExams > 40) {
                // Qualified for at least one MCAM

                $numMCAM++;

                // How many extra do they qualify for?

                $numExams -= 40;

                $numMCAM += (int)($numExams / 35);
            }
        }

        return $numMCAM;
    }
}