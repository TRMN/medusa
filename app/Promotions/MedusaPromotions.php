<?php

namespace App\Promotions;

use App\Grade;
use Exception;
use App\Branch;
use App\Rating;
use Carbon\Carbon;
use App\MedusaConfig;
use Illuminate\Support\Facades\Auth;

/**
 * Trait MedusaPromotions.
 *
 * {@inheritdoc} App\User
 */
trait MedusaPromotions
{
    /**
     * @var array Promotion requirements
     */
    public static $promotionRequirements = [];
    
    /**
     * @var array Look up next paygrade
     */
    public static $nextGrade = [];
    
    /**
     * Get either ALL promotion requirements or for the branch/service specified.
     *
     * @param null $want The service that the requirements are wanted for
     *
     * @return array|mixed
     */
    public function getRequirements($want = null)
    {
        if (empty(self::$promotionRequirements) === true) {
            foreach (Branch::all() as $branch) {
                if ($branch->branch === 'CIVIL') {
                    // Civilian branch has special handling
                    foreach (['DIPLOMATIC', 'INTEL', 'COMMONS', 'LORDS'] as $cbranch) {
                        if ($req = $this->loadRequirements($cbranch)) {
                            self::$promotionRequirements[$cbranch] = $req;
                        }
                    }
                } else {
                    if ($req = $this->loadRequirements($branch->branch)) {
                        self::$promotionRequirements[$branch->branch] = $req;
                    }
                }
            }
            
            self::$promotionRequirements['default'] = MedusaConfig::get('pp.requirements');
        }
        
        if (is_null($want) === true) {
            return self::$promotionRequirements;
        }
        
        return isset(self::$promotionRequirements[$want]) === true ? self::$promotionRequirements[$want] :
        self::$promotionRequirements['default'];
    }
    
    /**
     * Load the promotion requirements for a specific branch/service from the config collection.
     *
     * @param $branch
     *
     * @return bool|mixed|null
     */
    protected function loadRequirements($branch)
    {
        return MedusaConfig::get('pp.requirements.'.$branch, false);
    }
    
    /**
     * Get the next pay grade for the specified pay grade.
     *
     * @param $payGrade
     *
     * @return mixed
     */
    public function getNextGrade($payGrade)
    {
        if (empty(self::$nextGrade) === true) {
            self::$nextGrade = MedusaConfig::get('pp.nextGrade');
        }
        
        if (isset(self::$nextGrade[$payGrade]) === true) {
            return self::$nextGrade[$payGrade];
        }
        
        return false;
    }
    
    /**
     * Get the member's branch to use for the requirements.  If the member's branch is CIVIL, return the rating.
     *
     * @return string
     */
    private function getBranchForReq()
    {
        return $this->branch === 'CIVIL' ? $this->getRate() : $this->branch;
    }
    
    /**
     * Get promotion qualifications information for a user.
     *
     * @param null|string $payGrade2Check
     *
     * @return array
     */
    public function getPromotableInfo($payGrade2Check = null, $sfcCheck = true, $path = null)
    {
        $flags = [
            'tig'    => false,
            'points' => false,
            'exams'  => false,
            'early'  => false,
        ];
        
        if ($this->branch === 'SFC' && empty($this->dob) === true) {
            // Unable to determine if the member is under or over 18, so they are not promotable
            return $flags;
        }
        
        if (is_null($payGrade2Check) === true) {
            $nextGrade = $this->getNextGrade($this->rank['grade']);
            if (empty($nextGrade) === false) {
                $payGrade2Check = $nextGrade['next'][0];
            } else {
                return $flags;  // Can't determine what pay grade to check
            }
        }
        
        if ($this->branch === 'SFC' && $sfcCheck === true) {
            return $this->sfcIsPromotable($payGrade2Check);
        }
        
        $specialTig = 0;
        
        // Check for special promotion capabilities
        switch ($this->rank['grade']) {
            case 'E-4':
            case 'E-5':
            case 'E-6':
            case 'E-7':
            case 'E-8':
            case 'E-9':
            case 'E-10':
                // Check for promotion to WO-1 and O-1
                $special = $this->specialPromotionCheck(['WO-1', 'O-1']);
                if (count($special) > 0) {
                    $flags['next'] = $special;
                    $flags['exams'] = $flags['points'] = $flags['tig'] = true;
                }
                break;
        }
        
        // Check for gaps in some of the civilian pay grades
        if ($this->isGradeValidForUser($payGrade2Check) === false) {
            if (substr($payGrade2Check, 0, 1) == 'C') {
                // Civilian, determine what the next grade is and if they're eligible
                list($component, $step) = explode('-', $payGrade2Check);
                
                // Promotion requirements for this CIVIL branch
                $cReq = $this->getRequirements($this->getBranchForReq());
                // Tig for grade being checked
                $specialTig = isset($cReq[$payGrade2Check]['tig']) ?
                $cReq[$payGrade2Check]['tig'] : 0;
                $step++; // Start the check and the next one in sequence
                
                // Get the TiG of all the missing steps
                while ($this->isGradeValidForUser('C-'.$step) === false) {
                    if ($step > 23) {
                        // No next one found
                        return [
                            'tig'    => false,
                            'points' => false,
                            'exams'  => false,
                            'early'  => false,
                        ];
                    }
                    $specialTig += isset($cReq['C-'.$step]['tig']) ?
                    $cReq['C-'.$step]['tig'] : 0;
                    $step++;
                }
                // Get the Tig of the final step
                $specialTig += isset($cReq['C-'.$step]['tig']) ?
                $cReq['C-'.$step]['tig'] : 0;
                
                // Set the Paygrade to check to the final match
                $payGrade2Check = 'C-'.$step;
            } else {
                return [
                    'tig'    => false,
                    'points' => false,
                    'exams'  => false,
                    'early'  => false,
                ];
            }
        }
        
        if (empty($payGrade2Check) === false) {
            $requirements = $this->getRequirements($this->getBranchForReq());
            
            if (empty($requirements[$payGrade2Check]) === true) {
                // No requirement listed, just starting
                return [
                    'tig' => true,
                    'points' => true,
                    'exams' => true,
                    'early' => true,
                ];
            } else {
                $requirements = $requirements[$payGrade2Check];
            }
            
            // Steps were skipped, us that tig
            if ($specialTig > 0) {
                $requirements['tig'] = $specialTig;
            }
            
            if (is_null($path) === true) {
                $path = $this->getPath();
            }
            
            // Check TiG requirements.
            $flags['tig'] = empty($requirements['tig']) ? true :
            ($this->getTimeInGrade('months') >= $requirements['tig']);
            
            // They are at least an E-3/C-3 and their last promotion was not an early
            // one, check if they are promotable early
            
            if (in_array($this->rank['grade'], ['E-1', 'E-2', 'C-1', 'C-2']) ===
                false &&
                empty($this->rank['early']) === true &&
                $flags['tig'] === false) {
                    $flags['early'] = ($this->getTimeInGrade('months') >=
                        ($requirements['tig'] - 3));
                }
                
                // No requirements for a members path == not eligible
                if (empty($requirements[$path]) === false) {
                    // Check Points
                    if (empty($requirements[$path]['points']) === false) {
                        $flags['points'] = ($this->getTotalPromotionPoints() >=
                            $requirements[$path]['points']);
                    } else {
                        // By appointment only
                        $flags['points'] = true;
                    }
                    
                    // Check exams
                    if (empty($requirements[$path]['exam']) === false) {
                        $flags['exams'] =
                        $this->hasRequiredExams($requirements[$path]['exam']);
                    } else {
                        // No exam requirement
                        $flags['exams'] = true;
                    }
                }
                
                // Include what the next paygrade is
                
                if ($specialTig > 0 || is_null($payGrade2Check) === false) {
                    $flags['next'][] = $payGrade2Check;
                } else {
                    $next = $this->getNextGrade($this->rank['grade']);
                    $flags['next'][] = $next['next'][0];
                    
                    if (count($next['next']) > 1) {
                        $flags['next'][] = $next['next'][1];
                    }
                }
        }
        
        return $flags;
    }
    
    /**
     * Check eligibility for meritorious promotions.
     *
     * @param array $grades
     *
     * @return array
     */
    private function specialPromotionCheck(array $grades)
    {
        $path = $this->getPath();
        $ret = [];
        
        foreach ($grades as $grade) {
            $specialReq = $this->getRequirements($this->getBranchForReq())[$grade];
            
            if ($this->getTotalPromotionPoints() >=
                $specialReq[$path]['points'] &&
                $this->hasRequiredExams($specialReq[$path]['exam']) === true &&
                $this->getTimeInGrade('months') >= $specialReq['tig']) {
                    $ret[] = $grade;
                }
        }
        
        return $ret;
    }
    
    /**
     * Check if a SFC cadet or member is promotable based on age (< 18) or regular
     * requirements.
     *
     * @return array|null
     */
    private function sfcIsPromotable($payGrade2Check = null)
    {
        $age = $this->getAge();
        
        switch ($age) {
            case $age <= 8:
                return $this->rank['grade'] != 'C-1' ?
                ['next' => ['C-1'], 'tig' => true, 'points' => true, 'exams' => true, 'early' => false] : null;
                break;
            case $age <= 12:
                return $this->rank['grade'] != 'C-2' ?
                ['next' => ['C-2'], 'tig' => true, 'points' => true, 'exams' => true, 'early' => false] : null;
                break;
            case $age <= 15:
                return $this->rank['grade'] != 'C-3' ?
                ['next' => ['C-3'], 'tig' => true, 'points' => true, 'exams' => true, 'early' => false] : null;
                break;
            case $age <= 17:
                return $this->rank['grade'] != 'C-6' ?
                ['next' => ['C-6'], 'tig' => true, 'points' => true, 'exams' => true, 'early' => false] : null;
                break;
            default:
                // Adult member
                if (is_null($payGrade2Check) === true) {
                    // Adult members of the SFC start at C-7.  Check that they are at least a C-7
                    list($tmp, $payGrade) = explode('-', $this->getPayGrade());
                    if ($payGrade < 7) {
                        $payGrade2Check = 'C-7';
                    }
                }
                return $this->getPromotableInfo($payGrade2Check, false);
        }
    }
    
    /**
     * Can this member be promoted early?
     *
     * @param null|string $payGrade2Check
     *
     * @return array|null
     */
    public function isPromotableEarly($payGrade2Check = null)
    {
        switch ($this->branch) {
            case 'SFC':
                return $this->sfcIsPromotable($payGrade2Check);
                break;
            default:
                $flags = $this->getPromotableInfo($payGrade2Check);
                
                return ($flags['points'] && $flags['exams'] &&
                    $flags['early']) === true ? $flags['next'] : null;
        }
    }
    
    /**
     * Can this member be promoted?
     *
     * @param bool $tigCheck
     * @param null $payGrade2Check
     *
     * @return string|null
     */
    public function isPromotable($tigCheck = true, $payGrade2Check = null)
    {
        $return = $flags = null;
        
        switch ($this->branch) {
            case 'SFC':
                $flags = $this->sfcIsPromotable($payGrade2Check);
                break;
            default:
                $flags = $this->getPromotableInfo($payGrade2Check);
        }
        
        // If there are no exams and no points, they are not promotable.
        if (empty($flags['points']) === true || empty($flags['exams']) === true) {
            return false;
        }
        
        if ($flags['points'] && $flags['exams'] && isset($flags['next']) === true) {
            if ($flags['early'] === true) {
                $return = 'P-E [ '.implode(', ', $flags['next']).' ]';
            } elseif ($flags['tig'] === true || $tigCheck === false) {
                $return = 'P [ '.implode(', ', $flags['next']).' ]';
            }
        }
        
        return $return;
    }
    
    /**
     * Return the pay grade of an individual
     *
     * @return string
     */
    public function getPayGrade() {
        return $this->rank['grade'];
    }
    
    /**
     * Check if the pay grade is valid for the user.
     *
     * @param $payGrade2Check
     *
     * @return bool
     */
    public function isGradeValidForUser($payGrade2Check)
    {
        $branchesWithRatings = [
            'CIVIL',
            'RMMM'
        ];
        
        if (empty($this->rating) === false && (
            substr($this->getPayGrade(), 0, 1) === 'E' ||
            in_array($this->branch, $branchesWithRatings))) {
                // Check the available ranks for this rating
                return Rating::isPayGradeValid($payGrade2Check, $this->branch, $this->getRate());
            } else {
                // No rating or branch or pay grade does not have ratings, check the Grade collection
                return Grade::isPayGradeValidForBranch($payGrade2Check, $this->branch);
            }
    }
    
    /**
     * Promote the member to the specified rank and if needed, update promotion points for an early promotion.
     *
     * @param $rank
     * @param bool $early
     *
     * @return bool
     * @throws \Exception
     */
    public function promoteMember($rank, $early = false)
    {
        // Check for valid rank
        $parsedRank = explode('-', $rank);
        
        if (in_array($parsedRank[0], ['E', 'WO', 'C', 'O', 'F']) === false ||
            is_numeric($parsedRank[1]) === false) {
                // Not a valid rank
                return false;
            }
            
            // Special check for RMN
            
            if (empty($parsedRank[2]) === false &&
                in_array($parsedRank[2], ['A', 'B']) === false) {
                    // Not a valid RMN rank
                    return false;
                }
                
                $rank = [
                    'grade'        => $rank,
                    'date_of_rank' => date('Y-m-d'),
                ];
                
                if ($early === true) {
                    $rank['early'] = $rank['date_of_rank'];
                    // Get TiG requirement of new grade
                    $requirements = $this->getRequirements($this->getBranchForReq())[$rank['grade']];
                    
                    // Calculate how many months early the promotion is and update the number of points
                    $points = $this->points;
                    
                    if (empty($points['ep']) === true) {
                        $points['ep'] = 0;
                    }
                    $points['ep'] -= $requirements['tig'] -
                    $this->getTimeInGrade('months');
                    $this->points = $points;
                }
                
                $event = 'Rank changed from '.
                    Grade::getRankTitle(
                        $this->rank['grade'],
                        $this->getRate(),
                        $this->branch
                        ).' ('.$this->rank['grade'].') to ';
                        
                        $this->rank = $rank;
                        $this->promotionStatus = null;
                        
                        try {
                            $this->save();
                            
                            $this->writeAuditTrail(
                                (string) Auth::user()->id,
                                'update',
                                'users',
                                (string) $this->id,
                                json_encode($this),
                                'User@promoteMember'
                                );
                            
                            $history = [
                                'timestamp' => time(),
                                'event'     => $event.Grade::getRankTitle(
                                    $rank['grade'],
                                    $this->getRate(),
                                    $this->branch
                                    ).' ('.$rank['grade'].') on '.date('d M Y'),
                            ];
                            
                            $this->addServiceHistoryEntry($history);
                            
                            return true;
                        } catch (Exception $e) {
                            throw new Exception($e->getMessage());
                        }
    }
}