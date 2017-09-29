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
    public function mcamQual()
    {
        $numMCAM = 0;

        if ($this->hasAward('ESWP') === true || $this->hasAward('OSWP') === true) {
            // If they're not qualified for a SWP, they can't qual for a MCAM

            $numExams = count($this->getExamList());


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

    public function numToNextMcam()
    {
        if ($this->hasAward('MCAM')) {
            $numMcams = $this->awards['MCAM']['count'];

            return count($this->getExamList()) - (($numMcams * 35) + 5);

        }

        return null;
    }

    public function percentNextMcamLeft()
    {
        return floor($this->numToNextMcam() * 2.86);
    }

    public function percentNextMcamDone()
    {
        return 100-$this->percentNextMcamLeft();
    }
}