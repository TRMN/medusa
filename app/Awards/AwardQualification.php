<?php

namespace App\Awards;

use App\AwardLog;
use Carbon\Carbon;
use App\MedusaConfig;
use App\Utility\MedusaUtility;

/**
 * Trait AwardQualification.
 */
trait AwardQualification
{
    /**
     * Check if a member qualifies for a MCAM and if so, how many.
     *
     * @param bool $isNewAward
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function mcamQual($isNewAward = true)
    {
        $numMCAM = 0;

        if ($this->hasAward('ESWP') === true || $this->hasAward('OSWP') === true) {
            // If they're not qualified for a SWP, they can't qual for a MCAM

            $numExams = $this->getNumExams();

            if ($numExams >= 40) {
                // Qualified for at least one MCAM

                $numMCAM++;

                // How many extra do they qualify for?

                $numExams -= 40;

                $numMCAM += (int) ($numExams / 35);
            }
        }

        if ($numMCAM > 0) {
            // Qualified for at least 1 MCAM, update their ribbon rack
            $curNumMCAM = 0;
            $awardDates = [];

            if ($this->hasAward('MCAM')) {
                $curNumMCAM = $this->awards['MCAM']['count'];
                $awardDates = $this->awards['MCAM']['award_date'];
            }

            $newMCAM = $numMCAM - $curNumMCAM;

            $awardDate = (
            $isNewAward === true ?
                Carbon::now()->firstOfMonth()->addMonth()->toDateString() :
                '1970-01-01'
            );

            if ($newMCAM > 0) {
                // Calculated number of MCAM's is more the what the member
                // currently has, fill out the array of award dates
                $awardDates += array_fill(
                    $newMCAM - 1,
                    $newMCAM,
                    $awardDate
                );
            }

            $results = $this->addUpdateAward(
                [
                    'MCAM' => [
                        'count'      => $numMCAM,
                        'location'   => 'L',
                        'award_date' => $awardDates,
                        'display'    => true,
                    ],
                ]
            );

            if ($results === true && $isNewAward === true && $newMCAM > 0) {
                // MCAM awarded and it's a new award.  Add it to their history and
                // log it

                $this->logAward(
                    'MCAM',
                    $numMCAM,
                    [
                        'timestamp' => strtotime($awardDate),
                        'event'     => MedusaUtility::ordinal($numMCAM).
                                       ' Manticore Combat Action Medal earned on '.
                                       $awardDate,
                    ]
                );

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * How many more exams does the member need to their next MCAM.
     *
     * @return int|null
     */
    public function numToNextMcam()
    {
        if ($this->hasAward('MCAM')) {
            $numMcams = $this->awards['MCAM']['count'] + 1;

            return (($numMcams * 35) + 5) - count($this->getExamList());
        }
    }

    /**
     * Percentage left to next MCAM.
     *
     * @return float
     */
    public function percentNextMcamLeft()
    {
        return floor($this->numToNextMcam() * 2.86);
    }

    /**
     * Percentage of next MCAM done.
     *
     * @return float|int
     */
    public function percentNextMcamDone()
    {
        return 100 - $this->percentNextMcamLeft();
    }

    /**
     * Check if a member qualifies for a SWP.
     *
     * @param bool $isNewAward
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function swpQual($isNewAward = true)
    {
        // If they have at least 1 MCAM and DON'T have a SWP, it's an edge case based on how qual badges were
        // handled before.  Check that the MCAM was not just issued.

        if ($this->hasAward('MCAM') === true &&
            $this->hasAward('ESWP') === false &&
            $this->hasAward('OSWP') === false) {
            switch (substr($this->rank['grade'], 0, 1)) {
                case 'E':
                    $type = 'E';
                    break;
                case 'W':
                case 'M':
                case 'O':
                case 'F':
                    $type = 'O';
                    break;
                case 'C':
                    if (substr($this->rank['grade'], 2) < 12) {
                        $type = 'E';
                    } else {
                        $type = 'O';
                    }
            }

            // Check the date of the first MCAM
            if (Carbon::parse('today')->gt(Carbon::parse($this->awards['MCAM']['award_date'][0]))) {
                // MCAM was issued in the past.  Since you can't get a MCAM without qualifying for a SWP, add
                // The appropriate SWP to their record

                try {
                    $this->addUpdateAward(
                        [
                            $type.'SWP' => [
                                'count'      => 1,
                                'location'   => 'TL',
                                'award_date' => ['1970-01-01'],
                                'display'    => false,
                            ],
                        ]
                    );

                    return true;
                } catch (\Exception $e) {
                    return false;
                }
            }
        }

        // Get the users exams

        $exams = $this->getExamList();

        // Get the qualifications for a SWP

        $swpQual = MedusaConfig::get('awards.swp');

        // Get the branches to check for

        $swpBranches = MedusaConfig::get('awards.swp.branches', ['RMN', 'RMMC']);

        // Determine member's rank classification
        $swpType = null;
        switch (substr($this->rank['grade'], 0, 1)) {
            case 'E':
                $swpType = 'Enlisted';
                break;
            case 'W':
            case 'O':
            case 'F':
            case 'M':
                $swpType = 'Officer';
                break;
            case 'C':
                if (substr($this->rank['grade'], 2) < 12) {
                    $swpType = 'Enlisted';
                } else {
                    $swpType = 'Officer';
                }
        }

        if (is_null($swpQual) === false &&
            in_array($this->branch, $swpBranches) === true &&
            (($swpType === 'Enlisted' && $this->hasAward('ESWP') === false) ||
            ($swpType === 'Officer' && $this->hasAward('OSWP') === false))) {
            // Only process if the qualifications are defined,  it's a branch we check,
            // and they don't have their specific E|O SWP

            // Drill down to the specific branch and officer or enlisted

            $swpQual = $swpQual[$this->branch][$swpType];

            // Check for required

            $required = 0;

            foreach ($swpQual['Required'] as $exam) {
                if (isset($exams[$exam]) === true && $this->isPassingGrade($exams[$exam]['score']) === true) {
                    $required++;
                }
            }

            if ($required == count($swpQual['Required'])) {
                $required = true;
            } else {
                $required = false;
            }
            // Check the departments

            $departments = [];

            foreach ($swpQual['Departments'] as $dept => $deptExams) {
                foreach ($deptExams as $exam) {
                    if (isset($exams[$exam]) === true && $this->isPassingGrade($exams[$exam]['score']) === true) {
                        $departments[$dept] = true;
                        break;
                    }
                }
            }

            // Do they qualify?
            if ($required === true && count($departments) >= $swpQual['NumDepts']) {
                // Yes they do, add it.

                $awardDate = $isNewAward === true ? Carbon::now()->firstOfMonth()
                                                          ->addMonth()
                                                          ->toDateString() : '1970-01-01';

                $results = $this->addUpdateAward(
                    [
                        substr($swpType, 0, 1).'SWP' => [
                            'count'      => 1,
                            'location'   => 'TL',
                            'award_date' => [$awardDate],
                            'display'    => false,
                        ],
                    ]
                );

                if ($results === true && $isNewAward === true) {
                    // SWP successfully added and it's a new award.  Add it to
                    // their history and log it for BuTrain

                    $this->logAward(
                        substr($swpType, 0, 1).'SWP',
                        1,
                        [
                            'timestamp' => strtotime($awardDate),
                            'event'     => $this->branch.' '.$swpType.
                                           ' Space Warfare Pin earned on '.
                                           $awardDate,
                        ]
                    );
                }

                return true;
            }

            return false;
        }

        return false;
    }

    /**
     * Check if it's a passing score.
     *
     * @param string $score
     *
     * @return bool
     */
    public function isPassingGrade(string $score)
    {
        if (intval($score) >= 70) {
            return true;
        }

        switch (substr($score, 0, 4)) {
            case 'PASS':
            case 'BETA':
            case 'CREA':
                return true;
                break;
            default:
                return false;
        }
    }

    /**
     * Log the new award.
     *
     * @param $award
     * @param $qty
     * @param $event
     *
     * @throws \Exception
     *
     * @return bool
     */
    private function logAward($award, $qty, $event)
    {
        try {
            // Add this to the members service history
            $this->addServiceHistoryEntry($event);

            // Add a log entry for BuTrain
            AwardLog::create(
                [
                    'timestamp' => $event['timestamp'],
                    'member_id' => $this->member_id,
                    'award'     => $award,
                    'qty'       => $qty,
                ]
            );

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
