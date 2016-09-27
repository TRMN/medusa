<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;
use Jenssegers\Mongodb\Model as Eloquent;
use Medusa\Enums\MedusaDefaults;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;
    use \Medusa\Audit\MedusaAudit;
    use \Medusa\Permissions\MedusaPermissions;

    public static $rules = [
        'first_name'         => 'required|min:2',
        'last_name'          => 'required|min:2',
        'address1'           => 'required|min:4',
        'city'               => 'required|min:2',
        'state_province'     => 'required|min:2',
        'postal_code'        => 'required|min:2',
        'country'            => 'required',
        'email_address'      => 'required|email|unique:users',
        'password'           => 'confirmed',
        'branch'             => 'required',
        'primary_assignment' => 'required',
    ];

    public static $updateRules = [
        'first_name'     => 'required|min:2',
        'last_name'      => 'required|min:2',
        'address1'       => 'required|min:4',
        'city'           => 'required|min:2',
        'state_province' => 'required|min:2',
        'postal_code'    => 'required|min:2',
        'country'        => 'required',
        'email_address'  => 'required|email',
        'password'       => 'confirmed',
        'branch'         => 'required',
    ];

    public static $error_message = [
        'min'                         => 'The members :attribute must be at least :min characters long',
        'address1.required'           => 'Please enter the members street address',
        'address1.min'                => 'The street address must be at least :size characters long',
        'required'                    => 'Please enter the members :attribute',
        'state_province.required'     => 'Please enter the members state or province',
        'state_province.min'          => 'The members state or province must be at least :size character long',
        'date_format'                 => 'Please enter a date in the format YYYY-MM-DD',
        'branch.required'             => "Please select the members branch",
        'email_address.unique'        => 'That email address is already in use',
        'primary_assignment.required' => 'Please select a chapter'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'address1',
        'address2',
        'city',
        'state_province',
        'postal_code',
        'country',
        'phone_number',
        'email_address',
        'branch',
        'rating',
        'rank',
        'assignment',
        'peerages',
        'awards',
        'password',
        'permissions',
        'duty_roster',
        'registration_status',
        'application_date',
        'registration_date',
        'active',
        'dob',
        'osa',
        'idcard_printed',
        'note',
        'last_login',
        'previous_login',
        'lastUpdate',
    ];

    public function announcements()
    {
        return $this->hasMany('Announcement');
    }

    public function getFullName()
    {
        return trim(
            ucfirst($this->first_name) . ' ' .
            ( empty( $this->middle_name ) ? '' : ucfirst($this->middle_name) . ' ' ) .
            ucfirst($this->last_name) . ' ' .
            ( empty( $this->suffix ) ? '' : $this->suffix )
        );
    }

    /**
     * Return only the preferred rank title for a user
     *
     * @return mixed
     */
    public function getGreeting()
    {
        $this->getDisplayRank();

        $displayRank = $this->rank_title;

        if (isset( $this->rating ) && !empty( $this->rating )) {

            $rateGreeting = $this->getRateTitle($this->rank['grade']);

            if (isset( $rateGreeting ) === true && empty( $rateGreeting ) === false) {
                $displayRank = $rateGreeting;
            }
        }

        return $displayRank;
    }

    public function getGreetingArray()
    {
        $greeting['rank'] = $this->getGreeting();
        // To be used when viewing an announcement not published by the current user
        $greeting['last_name'] = $this->last_name;
        //To link to the user who published an announcement
        $greeting['user_id'] = $this->user_id;

        return $greeting;
    }

    /**
     * Set permanent rank, brevet rank and rating in one place
     */
    public function getDisplayRank()
    {
        $gradeDetails = Grade::where('grade', '=', $this->rank['grade'])->First();

        if (empty( $this->branch ) === true) {
            $this->branch = 'RMN';
        }

        if (empty( $gradeDetails->rank[$this->branch] ) === false) {
            $this->rank_title = $gradeDetails->rank[$this->branch];
        } else {
            $this->rank_title = $this->rank['grade'];
        }

        if (isset( $this->rating ) && !empty( $this->rating )) {
            if (is_array($this->rating) === true) {
                $results = Rating::where('rate_code', '=', $this->rating['rate'])->get();
            } else {
                $results = Rating::where('rate_code', '=', $this->rating)->get();
            }

            $rate = $results[0];

            if (is_array($this->rating) === true) {
                $currentRating = $this->rating['rate'];
            } else {
                $currentRating = $this->rating;
            }

            $this->rating =
                [
                    'rate'        => $currentRating,
                    'description' => $rate->rate['description']
                ];
        }
    }

    /**
     * Get the rate specific rank title, if any
     *
     * @param $rank
     *
     * @return mixed
     */
    public function getRateTitle($rank)
    {
        if (is_array($this->rating) === true) {
            $rateDetail = Rating::where('rate_code', '=', $this->rating['rate'])->get();
        } else {
            $rateDetail = Rating::where('rate_code', '=', $this->rating)->get();
        }

        if (isset( $rateDetail[0]->rate[$this->branch][$rank] ) === true && empty( $rateDetail[0]->rate[$this->branch][$rank] ) === false) {
            return $rateDetail[0]->rate[$this->branch][$rank];
        }

        return false;
    }

    public function getPostnominals()
    {
        $postnominals = [];

        // At the moment, the only postnominals we know about are for knighthoods stored in the peerage record

        foreach (empty( $this->peerages ) === false ? $this->peerages : [] as $peerage) {
            if (empty( $peerage['courtesy'] ) === true && empty( $peerage['postnominal'] ) === false) {
                $postnominals[$peerage['precedence']] = $peerage['postnominal']; // Order them by precedence
            }
        }

        if (count($postnominals) > 0) {
            ksort($postnominals);

            return ', ' . implode(', ', $postnominals);
        }

        return null;
    }

    public function getPeerages()
    {
        $landed = [];
        $knighthoods = [];

        if (empty( $this->peerages ) === false) {
            foreach ($this->peerages as $peerage) {
                if ($peerage['code'] == 'K') {
                    $knighthoods[$peerage['precedence']] = $peerage;
                } else {
                    $landed[$peerage['precedence']] = $peerage;
                }
            }

            ksort($landed);
            ksort($knighthoods);

            return array_merge($landed, $knighthoods);
        }

        return [];
    }

    /**
     * Get the chapter ID of the ship to which a member is assigned, regardless of
     * whether that's the primary, secondary, or some tertiary assignment.
     *
     */
    public function getAssignedShip()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                switch (Chapter::find($assignment['chapter_id'])['chapter_type']) {
                    case 'ship':
                    case 'bivouac':
                    case 'headquarters':
                    case 'company':
                    case 'station':
                    case 'shuttle':
                    case 'section':
                    case 'squad':
                    case 'platoon':
                    case 'battalion':
                    case 'barracks':
                    case 'outpost':
                    case 'fort':
                        return $assignment['chapter_id'];
                        break;
                }
            }
        }
        return false;
    }

    public function getAssignmentId($position)
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty( $assignment[$position] ) === false) {
                    if (empty( $assignment['chapter_id'] )) {
                        return false;
                    }
                    return $assignment['chapter_id'];
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function getPrimaryAssignmentId()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentId()

        return $this->getAssignmentId('primary');
    }

    public function getSecondaryAssignmentId()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentId()

        return $this->getAssignmentId('secondary');
    }

    public function getAssignmentName($position)
    {
        $chapter = Chapter::find($this->getAssignmentId($position));
        if (empty( $chapter ) === false) {
            return $chapter->chapter_name;
        } else {
            return false;
        }
    }

    public function getPrimaryAssignmentName()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentName()

        return $this->getAssignmentName('primary');
    }

    public function getSecondaryAssignmentName()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentName()

        return $this->getAssignmentName('secondary');
    }

    public function getAssignmentDesignation($position)
    {
        // Why didn't I follow DRY for all of these???

        $chapter = Chapter::find($this->getAssignmentId($position));
        if (empty( $chapter ) === false) {
            return $chapter->hull_number;
        } else {
            return false;
        }
    }

    public function getPrimaryAssignmentDesignation()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentDesignation()

        return $this->getAssignmentDesignation('primary');
    }

    public function getSecondaryAssignmentDesignation()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getAssignmentDesignation()

        return $this->getAssignmentDesignation('secondary');
    }

    public function getBillet($position)
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty( $assignment[$position] ) === false) {
                    return $assignment['billet'];
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function getPrimaryBillet()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getBillet()

        return $this->getBillet('primary');
    }

    public function getSecondaryBillet()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getBillet()

        return $this->getBillet('secondary');
    }

    public function getDateAssigned($position)
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty( $assignment[$position] ) === false) {
                    if (isset( $assignment['date_assigned'] ) === true) {
                        return $assignment['date_assigned'];
                    } else {
                        return 'Unknown';
                    }
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function getPrimaryDateAssigned()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getDateAssigned()

        return $this->getDateAssigned('primary');
    }

    public function getSecondaryDateAssigned()
    {
        // Maintain backward compatibility
        // TODO: Refactor all calls to use getDateAssigned()

        return $this->getDateAssigned('secondary');
    }

    public function getBilletForChapter($chapterId)
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if ($assignment['chapter_id'] == $chapterId) {
                    return $assignment['billet'];
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function getTimeInGrade($short = false)
    {
        if (empty( $this->rank['date_of_rank'] ) === false) {
            $dorObj = new DateTime();
            list( $year, $month, $day ) = explode('-', $this->rank['date_of_rank']);
            $dorObj->setDate($year, $month, $day);

            $timeInGrade = $dorObj->diff(new DateTime("now"));

            if ($short === true) {
                $tig = ( $timeInGrade->format('%y') * 12 ) + $timeInGrade->format('%m');
                if ($timeInGrade->format('%d') > 25) {
                    $tig += 1;
                }
                return str_pad($tig, 2, '0', STR_PAD_LEFT) . ' Mo';
            } else {
                return $timeInGrade->format('%y Year(s), %m Month(s), %d Day(s)');
            }
        } else {
            return null;
        }
    }

    public function getTimeInService()
    {
        if (empty( $this->registration_date ) === false) {
            $regDateObj = new DateTime();
            list( $year, $month, $day ) = explode('-', $this->registration_date);
            $regDateObj->setDate($year, $month, $day);

            $timeInService = $regDateObj->diff(new DateTime("now"));
            return $timeInService->format('%y Year(s), %m Month(s), %d Day(s)');
        } else {
            return null;
        }
    }

    public function getExamList($options = null)
    {
        if (is_null($options) === false) {
            if (is_array($options) === false) {
                $branch = $options; // backwards compatibility
            } else {
                if (empty( $options['branch'] ) === true) {
                    $branch = null;
                } else {
                    $branch = $options['branch'];
                }

                if (empty( $options['after'] ) === true) {
                    $after = null;
                } else {
                    $after = strtotime($options['after']);
                }

                if (empty( $options['class'] ) === true) {
                    $class = null;
                } else {
                    $class = $options['class'];
                }

                if (empty( $options['since'] ) === true) {
                    $since = null;
                } else {
                    $since = strtotime($options['since']);
                }
            }
        } else {
            $branch = null;
        }

        $exams = Exam::where('member_id', '=', $this->member_id)->first();

        if (empty( $exams ) === false) {
            if (is_null($branch) === true) {
                $list = $exams->exams;
            } else {
                // filter by branch
                $list = array_where(
                    $exams->exams,
                    function ($key, $value) use ($branch) {
                        if (preg_match('/^.*-(' . $branch . ')-.*$/', $key) === 1) {
                            return true;
                        }
                    }
                );
            }

            if (empty( $after ) === false) {
                // filter by date
                $list = array_where(
                    $list,
                    function ($key, $value) use ($after) {
                        if (strtotime($value['date']) >= $after && strtotime($value['date']) < strtotime(
                                '+2 month',
                                $after
                            )
                        ) {
                            return true;
                        }
                    }
                );
            }

            if (empty( $since ) === false) {
                // Filter by date entered
                $list = array_where(
                    $list,
                    function ($key, $value) use ($since) {
                        if (empty( $value['date_entered'] ) === true) {
                            return false;
                        }

                        if (strtotime($value['date_entered']) >= $since) {
                            return true;
                        }
                    }
                );
            }

            if (empty( $class ) === false) {
                //filter by class of exams
                switch ($class) {
                    case "enlisted":
                        //handle enlisted exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-000[1-9]$/';

                        $list = $this->filterExams($list, $examMatch);
                        break;

                    case "warrant":
                        //handle warrant exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-001[1-9]$/';

                        $list = $this->filterExams($list, $examMatch);
                        break;

                    case "officer":
                        //handle officer exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-01[0-9][1-9]$/';

                        $list = $this->filterExams($list, $examMatch);
                        break;

                    case "flag":
                        //handle flag exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-100[1-9]$/';

                        $list = $this->filterExams($list, $examMatch);
                        break;

                    case "officer+flag":
                        $list =
                            array_merge(
                                $this->getExamList(['class' => 'officer']),
                                $this->getExamList(['class' => 'flag'])
                            );
                        break;
                }
            }

            ksort($list);
            return $list;
        } else {
            return [];
        }
    }

    private function getHighestExamFromList(array $list)
    {
        if (count($list) < 1) {
            return [];
        }

        $list = array_sort(
            $list,
            function ($value) {
                return $value['date'];
            }
        );

        end($list);
        return [key($list) => last($list)];
    }

    /**
     * Function filterExams
     *
     * @param array  $exams
     * @param string $search
     *
     * @return array $list
     */

    private function filterExams(array $exams, $search)
    {
        $list = array_where(
            $exams,
            function ($key, $value) use ($search) {
                if (preg_match($search, $key) === 1) {
                    return true;
                }
            }
        );
        return $list;
    }

    public function getHighestMainLineExamForBranch($class = null)
    {
        $options['branch'] = $this->branch;
        if (empty( $class ) === false) {
            $options['class'] = $class;
        }

        $exams = $this->getExamList($options);

        if (count($exams) < 1) {
            // No exams found for branch, check RMN
            $options['branch'] = 'RMN';

            $exams = $this->getExamList($options);
        }

        $results = $this->getHighestExamFromList($exams);

        return key($results);
    }

    /**
     * Retrieve the highest level Enlisted exam a user has taken
     *
     * @return String $exam
     */
    public function getHighestEnlistedExam()
    {
        $exams = $this->getExamList(array('class' => 'enlisted'));

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    public function getHighestWarrantExam()
    {
        $exams = $this->getExamList(array('class' => 'warrant'));

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    public function getHighestOfficerExam()
    {
        $exams = $this->getExamList(array('class' => 'officer+flag'));

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    public function getHighestFlagExam()
    {
        $exams = $this->getExamList(array('class' => 'flag'));

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    public function getCompletedExams($after)
    {
        $exams = $this->getExamList(['after' => $after]);

        $list = array_where(
            $exams,
            function ($key, $value) use ($after) {
                if (intval($value['score']) > 70 || strtoupper($value['score'] == 'PASS')) {
                    return $value;
                }
            }
        );

        return implode(', ', array_keys($list));
    }

    public function getExamLastUpdated()
    {
        $exams = Exam::where('member_id', '=', $this->member_id)->first();

        if (isset( $exams ) === true) {
            return $exams['updated_at'];
        } else {
            return false;
        }
    }

    public function hasNewExams($branch = null)
    {
        $options['since'] = Auth::user()->getLastLogin();

        if (is_null($branch) === false) {
            $options['branch'] = $branch;
        }

        if (count($this->getExamList($options)) > 0) {
            return true;
        }

        return false;
    }

    public function assignCoPerms()
    {
        $this->updatePerms(
            [
                'DUTY_ROSTER',
                'EXPORT_ROSTER',
                'EDIT_WEBSITE',
                'ASSIGN_NONCOMMAND_BILLET',
                'PROMOTE_E6O1',
                'REQUEST_PROMOTION',
                'CHAPTER_REPORT',
            ]
        );

        return true;
    }

    public function assignAllPerms()
    {
        $this->updatePerms(['ALL_PERMS']);

        return true;
    }

    public function assignBuShipPerms()
    {
        $this->updatePerms(
            [
                'COMMISSION_SHIP',
                'DECOMMISSION_SHIP',
                'EDIT_SHIP',
                'VIEW_DSHIPS',
                'VIEW_SU',
            ]
        );

        return true;
    }

    public function assignBuPersPerms()
    {
        $this->updatePerms(
            [
                'ADD_MEMBER',
                'DEL_MEMBER',
                'EDIT_MEMBER',
                'VIEW_MEMBERS',
                'PROC_APPLICATIONS',
                'PROC_XFERS',
                'ADD_BILLET',
                'DEL_BILLET',
                'EDIT_BILLET',
            ]
        );

        return true;
    }

    public function assignSpaceLordPerms()
    {
        $this->assignCoPerms();
        $this->updatePerms(['VIEW_CHAPTER_REPORTS']);

        return true;
    }

    public function updatePerms(array $perms)
    {
        $this->permissions = array_unique(array_merge($this->permissions, $perms));

        if (is_null(Auth::user())) {
            $user = 'system user';
        } else {
            $user = (string)Auth::user()->_id;
        }

        $this->osa = false;

        $this->lastUpdate = time();

        $this->writeAuditTrail(
            $user,
            'update',
            'users',
            (string)$this->_id,
            json_encode($this->permissions),
            'User@updatePerms'
        );

        $this->save();

        return true;
    }

    public function deletePerm($perm)
    {
        $this->permissions = array_where(
            $this->permissions,
            function ($key, $value) use ($perm) {
                return $value != $perm;
            }
        );

        if (is_null(Auth::user())) {
            $user = 'system user';
        } else {
            $user = (string)Auth::user()->_id;
        }

        $this->osa = false;
        $this->lastUpdate = time();

        $this->writeAuditTrail(
            $user,
            'update',
            'users',
            (string)$this->_id,
            json_encode($this->permissions),
            'User@deletePerms'
        );

        $this->save();

        return true;
    }

    public function deletePeerage($peerageId)
    {
        $peerages = array_where(
            $this->peerages,
            function ($key, $value) use ($peerageId) {
                if ($value['peerage_id'] != $peerageId) {
                    return true;
                }

                return false;
            }
        );

        $this->peerages = $peerages;

        $this->save();

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'users',
            $this->id,
            $this->toJson(),
            'User@deletePeerage'
        );

        return true;
    }

    public function buildIdCard($showFullGrade = false)
    {
        $idCard = Image::make(public_path() . '/images/TRMN-membership-card.png');

        $name = $this->getFullName();
        $fontSize = strlen($name) < 30 ? 48 : 38;
        $idCard->text(
            $name,
            382,
            317,
            function ($font) use ($fontSize) {
                $font->file(public_path() . "/fonts/24bd1ba4-1474-491a-91f2-a13940159b6d.ttf");
                $font->size($fontSize);
                $font->align('center');
            }
        );

        $idCard->text(
            $this->getAssignmentName('primary'),
            382,
            432,
            function ($font) {
                $font->file(public_path() . "/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf");
                $font->align('center');
                $font->size(40);
            }
        );

        $primaryBillet = $this->getBillet('primary');
        $fontSize = strlen($primaryBillet) < 30 ? 40 : 30;

        $idCard->text(
            $primaryBillet,
            382,
            527,
            function ($font) use ($fontSize) {
                $font->file(public_path() . "/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf");
                $font->align('center');
                $font->size($fontSize);
            }
        );

        $rankCode = substr($this->rank['grade'], 0, 1);
        if ($showFullGrade === true) {
            $rankCode = $this->rank['grade'];
        }

        switch ($rankCode) {
            case 'C':
                switch ($this->branch) {
                    case 'RMACS':
                        $rankCode .= '-AC';
                        break;
                    case 'RMMM':
                        $rankCode .= '-MM';
                        break;
                    case 'SFS':
                        $rankCode .= '-SFC';
                        break;
                    case 'INTEL':
                        $rankCode .= '-IS';
                        break;
                    case 'CIVIL':
                        $rankCode .= '-CD';
                }
                break;
            default;
                break;
        }

        switch ($this->branch) {
            case 'RMACS':
            case 'RMMM':
            case 'SFS':
            case 'CIVIL':
                $seal = 'CIV.png';
                break;
            case 'INTEL':
                $seal = 'INTEL.png';
                break;
            case 'IAN':
                $seal = 'IAN.png';
                break;
            case 'RHN':
                $seal = 'RHN.png';
                break;
            case 'GSN':
                $seal = 'GSN.png';
                break;
            case 'RMMC':
                $seal = 'RMMC.png';
                break;
            case 'RMA':
                $seal = 'RMA.png';
                break;
            default:
                $seal = 'RMN.png';
        }

        $idCard->text(
            $rankCode,
            153,
            628,
            function ($font) {
                $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
                $font->align('center');
                $font->size(40);
                $font->color('#BE1E2D');
            }
        );

        $peerages = $this->getPeerages();

        if (empty( $peerages ) === false) {
            $pCode = $peerages[0]['code'];

            if ($pCode == "K" && substr(
                    Korders::where('classes.postnominal', '=', $peerages[0]['postnominal'])->first()->getClassName(
                        $peerages[0]['postnominal']
                    ),
                    0,
                    6
                ) != 'Knight'
            ) {
                $pCode = '';
            }

            $idCard->text(
                $pCode,
                392,
                628,
                function ($font) {
                    $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
                    $font->align('center');
                    $font->size(40);
                    $font->color('#BE1E2D');
                }
            );
        }

        $idCard->text(
            $this->branch,
            628,
            628,
            function ($font) {
                $font->file(public_path() . "/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf");
                $font->align('center');
                $font->size(40);
                $font->color('#BE1E2D');
            }
        );

        $idCard->text(
            $this->member_id,
            855,
            250,
            function ($font) {
                $font->file(public_path() . "/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf");
                $font->align('center');
                $font->size(20);
            }
        );

        $idCard->insert(
            base64_encode(
                QrCode::format('png')->margin(1)->size(150)->errorCorrection('H')->generate($this->member_id)
            ),
            'top-left',
            780,
            252
        );

        $idCard->insert(public_path() . '/seals/' . $seal, 'top-left', 747, 400);

        return $idCard;
    }

    static function normalizeStateProvince($state)
    {
        if (strlen($state) == 2) {
            /** No need to validate, we don't know all 2 letter state and province abbreviations */
            return strtoupper($state);
        }

        if (strlen($state) == 3 && substr($state, -1) == '.') {
            // We have a 2 letter abbreviation followed by a period.  Strip the period and slam to upper case
            return strtoupper(substr($state, 0, 2));
        }

        if (strlen($state) == 4 && substr($state, -1) == '.' && substr($state, -3, 1) == '.') {
            // We have a 2 letter abbreviation with periods between the letters, like D.C. or B.C.
            return strtoupper(substr($state, 0, 1) . substr($state, -2, 1));
        }

        if (substr($state, 2, 2) == ' -') {
            // We may have a 2 letter abbreviation followed by the full name, try and validate
            if (array_key_exists(strtoupper(substr($state, 0, 2)), MedusaDefaults::STATES_BY_ABREVIATION) === true) {
                return strtoupper(substr($state, 0, 2));
            }
        }

        // Nothing else hits, check and see if we know the 2 letter abbreviation

        if (array_key_exists(strtoupper($state), MedusaDefaults::STATES_BY_NAME) === true) {
            $tmp = MedusaDefaults::STATES_BY_NAME;
            return $tmp[strtoupper($state)];
        }

        // No hits, return it un altered

        return $state;
    }

    static function getNextAvailableMemberId()
    {
        $uniqueMemberIds = self::_getMemberIds();

        if (sizeof($uniqueMemberIds) == 0) {
            return "-0000-" . date('y');
        }

        asort($uniqueMemberIds);

        $lastUsedId = array_pop($uniqueMemberIds);

        $newNumber = $lastUsedId + 1;

        if ($newNumber > 9999) {
            $newNumber = 0;
        }

        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $yearCode = date('y');

        return "-$newNumber-$yearCode";
    }

    static function getFirstAvailableMemberId($honorary = false)
    {
        $uniqueMemberIds = self::_getMemberIds();

        if (sizeof($uniqueMemberIds) == 0) {
            return "-0000" . date('y');
        }

        asort($uniqueMemberIds);

        $lastId = 0;

        foreach ($uniqueMemberIds as $memberId) {
            if (( intval($lastId) + 1 < intval($memberId) ) && ( $honorary === true || intval($lastId) + 1 > 200 )) {
                return '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT) . '-' . date('y');
            }
            $lastId = $memberId;
        }

        return self::getNextAvailableMemberId();
    }

    static function _getMemberIds()
    {
        $memberIds = self::all(['member_id']);
        $uniqueMemberIds = [];

        foreach ($memberIds as $record) {
            $uniqueMemberIds[] = intval(substr($record->member_id, 4, 4));
        }

        return $uniqueMemberIds;
    }

    public function getReminderEmail()
    {
        return $this->email_address;
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function updateLastLogin()
    {
        $this->previous_login = $this->last_login;
        $this->last_login = date('Y-m-d H:i:s');
        $this->save();
    }

    public function getLastLogin()
    {
        if (empty( $this->previous_login ) === true) {
            return date('Y-m-d', strtotime('-2 weeks'));
        }
        return date('Y-m-d', strtotime($this->previous_login));
    }

    public function getLastUpdated()
    {
        if (empty( $this->lastUpdate ) == true) {
            return strtotime($this->updated_at->toDateTimeString());
        }

        return $this->lastUpdate;
    }

    public function updateLastUpdated()
    {
        $this->lastUpdate = time();
        $this->save();
    }

    public function checkRostersForNewExams()
    {
        if ($this->id != Auth::user()->id || empty($this->duty_roster) === true) {
            return false;
        }
        $rosters = explode(',', $this->duty_roster);
        $newExams = false;

        if (count($rosters) > 0 && is_array($rosters) === true) {
            foreach ($rosters as $roster) {
                if (Chapter::find($roster)->crewHasNewExams()) {
                    $newExams = true;
                }
            }
        }

        return $newExams;
    }
}
