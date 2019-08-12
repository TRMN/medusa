<?php

namespace App;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Audit\MedusaAudit;
use Illuminate\Support\Arr;
use App\Common\MedusaCommon;
use App\Enums\MedusaDefaults;
use App\Awards\AwardQualification;
use Laravel\Passport\HasApiTokens;
use App\Promotions\MedusaPromotions;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Permissions\MedusaPermissions;
use Illuminate\Notifications\Notifiable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Auth\Passwords\CanResetPassword;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use DesignMyNight\Mongodb\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * MEDUSA User model.
 *
 * @property string id
 * @property string forum_last_login
 * @property string first_name
 * @property string middle_name
 * @property string last_name
 * @property string suffix
 * @property string address1
 * @property string address2
 * @property string city
 * @property string state_province
 * @property string postal_code
 * @property string country
 * @property string phone_number
 * @property string email_address
 * @property string branch
 * @property array|string rating
 * @property array rank
 * @property array assignment
 * @property array peerages
 * @property array awards
 * @property string password
 * @property array permissions
 * @property string duty_roster
 * @property string registration_status
 * @property string application_date
 * @property string registration_date
 * @property string active
 * @property string dob
 * @property string osa
 * @property string idcard_printed
 * @property string note
 * @property string last_login
 * @property string previous_login
 * @property string lastUpdate
 * @property string hasEvents
 * @property string unitPatchPath
 * @property string usePeerageLands
 * @property string extraPadding
 * @property string last_forum_login
 * @property array points
 * @property string path
 * @property array history
 * @property string rank_title
 * @property string member_id
 * @property object updated_at
 * @property string promotionStatus
 * @property array previous
 */
class User extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable,
        MedusaAudit,
        MedusaPermissions,
        HasApiTokens,
        CanResetPassword,
        AwardQualification,
        MedusaCommon,
        MedusaPromotions;

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
        'phone_number'       => 'nullable|sometimes|regex:/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/',
    ];

    public static $updateRules = [
        'first_name'            => 'required|min:2',
        'last_name'             => 'required|min:2',
        'address1'              => 'required|min:4',
        'city'                  => 'required|min:2',
        'state_province'        => 'required|min:2',
        'postal_code'           => 'required|min:2',
        'country'               => 'required',
        'email_address'         => 'required|email',
        'password'              => 'confirmed',
        'branch'                => 'required',
        'phone_number'          => 'nullable|sometimes|regex:/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$/',
        'primary_assignment'    => 'required',
        'primary_billet'        => 'required',
        'primary_date_assigned' => 'required',
        'dob'                   => 'required',
        'registration_status'   => 'required',
        'registration_date'     => 'required',
        'application_date'      => 'required',
    ];

    public static $error_message = [
        'min'                            => 'The members :attribute must be at least :min characters long',
        'address1.required'              => 'Please enter the members street address',
        'address1.min'                   => 'The street address must be at least :size characters long',
        'required'                       => 'Please enter the members :attribute',
        'state_province.required'        => 'Please enter the members state or province',
        'state_province.min'             => 'The members state or province must be at least :size character long',
        'date_format'                    => 'Please enter a date in the format YYYY-MM-DD',
        'branch.required'                => 'Please select the members branch',
        'email_address.unique'           => 'That email address is already in use',
        'primary_assignment.required'    => 'Please select a chapter',
        'primary_billet.required'        => 'Please select a billet',
        'primary_date_assigned.required' => 'Please specify the date assigned',
        'dob.required'                   => 'Please enter a date of birth',
        'phone_number'                   => 'Please enter a valid telephone number',
        'registration_status'            => 'Please select a registration status',
        'registration_date'              => 'Please enter the date of registration',
        'application_date'               => 'Please enter the date of application',
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
        'hasEvents',
        'unitPatchPath',
        'usePeerageLands',
        'extraPadding',
        'last_forum_login',
        'points',
        'path',
        'history',
        'promotionStatus',
        'previous',
    ];

    /**
     * Get the current age of the member
     *
     * @return int
     */
    public function getAge()
    {
        return Carbon::now()->diffInYears(Carbon::parse($this->dob));
    }

    /**
     * Get the number of exams with a passing score for a member.
     *
     * @return int
     */
    public function getNumExams()
    {
        $numExams = 0;

        foreach ($this->getExamList() as $exam) {
            if ($this->isPassingGrade($exam['score']) === true) {
                $numExams++;
            }
        }

        return $numExams;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email_address;
    }

    /**
     * Get email for password reset functions.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email_address;
    }

    /**
     * Get users name with rank.
     *
     * @return string
     */
    public function getGreetingAndName()
    {
        return $this->getGreeting().' '.$this->getFullName();
    }

    /**
     * Get the users full name.
     *
     * @param bool $lastFirst Return name is Last, First Middle instead of
     *                        First Middle Last
     *
     * @return string
     */
    public function getFullName($lastFirst = false)
    {
        if ($lastFirst === true) {
            return trim(
                $this->last_name.
                (empty($this->suffix) ? '' : $this->suffix).', '.
                $this->first_name.' '.
                (empty($this->middle_name) ? '' :
                    $this->middle_name.' ')
            );
        } else {
            return trim(
                $this->first_name.' '.
                (empty($this->middle_name) ? '' :
                    $this->middle_name.' ').
                $this->last_name.' '.
                (empty($this->suffix) ? '' : $this->suffix)
            );
        }
    }

    /**
     * Return only the preferred rank title for a user.
     *
     * @return string
     */
    public function getGreeting()
    {
        $this->getDisplayRank();

        $displayRank = $this->rank_title;

        if (isset($this->rating) && ! empty($this->rating)) {
            $rateGreeting = $this->getRateTitle($this->rank['grade']);

            if (isset($rateGreeting) === true && empty($rateGreeting) === false) {
                $displayRank = $rateGreeting;
            }
        }

        return $displayRank;
    }

    /**
     * Get the greeting info in an array.
     *
     * @return array
     */
    public function getGreetingArray()
    {
        $greeting['rank'] = $this->getGreeting();
        // To be used when viewing an announcement not published by the current user
        $greeting['last_name'] = $this->last_name;

        return $greeting;
    }

    /**
     * Dynamically set the rank title.
     *
     * @TODO The function name really be changed, as this is a dynamic setter,
     *     not a getter
     *
     * @return bool
     */
    public function getDisplayRank()
    {
        $gradeDetails = Grade::where('grade', '=', $this->rank['grade'])->first();

        if (empty($this->branch) === true) {
            $this->branch = 'RMN';
        }

        if (empty($gradeDetails->rank[$this->branch]) === false) {
            $this->rank_title = $gradeDetails->rank[$this->branch];
        } else {
            $this->rank_title = $this->rank['grade'];
        }

        // Fix issue resulting from combining Intel and Diplomatic branches into one.
        if ($this->branch == 'CIVIL' && empty($this->rating) === true) {
            $this->rating = 'DIPLOMATIC';
            $this->save();
        }

        if (! empty($this->rating)) {
            if (is_array($this->rating) === true) {
                $results = Rating::where('rate_code', '=', $this->rating['rate'])
                                 ->first();
            } else {
                $results = Rating::where('rate_code', '=', $this->rating)->first();
            }

            if (is_array($this->rating) === true) {
                $currentRating = $this->rating['rate'];
            } else {
                $currentRating = $this->rating;
            }

            $this->rating = [
                'rate'        => $currentRating,
                'description' => $results->rate['description'],
            ];
        }

        return true;
    }

    /**
     * Get the users rating.
     *
     * @return string|null
     */
    public function getRate()
    {
        if (empty($this->rating) === false) {
            if (is_array($this->rating) === true) {
                return $this->rating['rate'];
            }

            return $this->rating;
        } elseif ($this->branch == 'CIVIL') {
            return 'DIPLOMATIC';
        }
        return null;
    }

    /**
     * Get the rate specific rank title, if any.
     *
     * @param $rank
     *
     * @return bool|string
     */
    public function getRateTitle($rank)
    {
        if (is_array($this->rating) === true) {
            $rateDetail =
                Rating::where('rate_code', '=', $this->rating['rate'])->first();
        } else {
            $rateDetail =
                Rating::where('rate_code', '=', $this->rating)->first();
        }

        if (empty($rateDetail->rate[$this->branch][$rank]) === false) {
            return $rateDetail->rate[$this->branch][$rank];
        }

        return false;
    }

    /**
     * Get Date of Rank.
     *
     * @return string
     */
    public function getDateOfRank()
    {
        return $this->rank['date_of_rank'];
    }

    /**
     * Get a users Post Nominals.
     *
     * @return null|string
     */
    public function getPostnominals()
    {
        if (empty($this->awards) === false) {
            return $this->getPostnominalsFromAwards();
        } elseif (empty($this->perages) === false) {
            return $this->getPostnominalsFromPeerages();
        } else {
            return;
        }
    }

    /**
     * Get a users Post Nominals from awards.
     *
     * @return string
     */
    public function getPostnominalsFromAwards()
    {
        $postnominals = [];

        foreach ($this->awards as $code => $info) {
            $award = Award::getAwardByCode($code);
            if (empty($award->post_nominal) === false) {
                // It has a post-nominal
                $postnominals[$award->display_order] = $award->post_nominal;
            }
        }

        if (count($postnominals) > 0) {
            ksort($postnominals);

            return ', '.implode(', ', $postnominals);
        }
    }

    /**
     * Get a users Post Nominals from their peerages.
     *
     * @return string
     */
    private function getPostnominalsFromPeerages()
    {
        $postnominals = [];

        foreach ($this->peerages as $peerage) {
            if (empty($peerage['courtesy']) === true &&
                empty($peerage['postnominal']) === false) {
                $postnominals[$peerage['precedence']] =
                    $peerage['postnominal']; // Order them by precedence
            }
        }

        if (count($postnominals) > 0) {
            ksort($postnominals);

            return ', '.implode(', ', $postnominals);
        }
    }

    /**
     * Get a users peerages.
     *
     * @param bool $detail
     *
     * @return array
     */
    public function getPeerages($detail = false)
    {
        $landed = [];
        $knighthoods = [];

        if (empty($this->peerages) === false) {
            foreach ($this->peerages as $peerage) {
                if ($peerage['code'] == 'K') {
                    $knighthoods[strval($peerage['precedence'])] = $peerage;
                } else {
                    $landed[strval($peerage['precedence'])] = $peerage;
                }
            }

            ksort($landed);
            ksort($knighthoods);

            if ($detail === true) {
                return ['landed' => $landed, 'knighhoods' => $knighthoods];
            }

            return array_merge($landed, $knighthoods);
        }

        return [];
    }

    /**
     * Get the name of a users Peerage lands.
     *
     * @return null|string
     */
    public function getNameofLands()
    {
        $peerages = $this->getPeerages(true);

        $land =
            empty($peerages['landed']) ? null : array_shift($peerages['landed']);

        return isset($land['lands']) ? $land['lands'] : null;
    }

    /**
     * Get the chapter ID of the ship to which a member is assigned, regardless
     * of whether that's the primary, secondary, or some tertiary assignment.
     *
     * @return bool|string
     */
    public function getAssignedShip()
    {
        $holding = MedusaConfig::get('chapter.holding');

        if (isset($this->assignment) == true) {
            foreach ($this->assignment as $assignment) {
                // If this is a holding chapter, return that chapter id
                if (in_array($assignment['chapter_id'], $holding) === true) {
                    return $assignment['chapter_id'];
                }

                $chapter = Chapter::find($assignment['chapter_id']);

                switch ($chapter->chapter_type) {
                    case 'ship':
                    case 'bivouac':
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
                    case 'small_craft':
                    case 'lac':
                    case 'theater':
                    case 'headquarters':
                        return $assignment['chapter_id'];
                        break;
                }
            }
        }

        return false;
    }

    /**
     * Is this user the CO of the fleet their assigned ship is part of.
     *
     * @return bool
     */
    public function isFleetCO()
    {
        $fleet = Chapter::find($this->getAssignedShip())->getAssignedFleet(true);

        if (is_null($fleet) === false &&
            Chapter::find($fleet)->getCO()['id'] == $this->id) {
            return true;
        }

        return false;
    }

    /**
     * Is this user the CO of the ship they are assigned to.
     *
     * @return bool
     */
    public function isCoAssignedShip()
    {
        $chapter = $this->getAssignedShip();

        return $chapter !== false ? $this->isCommandingOfficer($this->getAssignedShip()) : false;
    }

    /**
     * Is this user the CO of the specified Chapter?
     *
     * @param $chapterId
     *
     * @return bool
     */
    public function isCommandingOfficer($chapterId)
    {
        $chapterCO = Chapter::find($chapterId)->getCO();

        if (is_null($chapterCO) === false &&
            ($chapterCO['id'] == $this->id ||
             Auth::user()->hasAllPermissions() === true)) {
            return true;
        }

        return false;
    }

    /**
     * Find an assignment associated with this user.
     *
     * @param $chapterId - The chapter ID of the chapter we want to look for
     *
     * @return array
     */
    public function findAssignment($chapterID)
    {
        if (empty($chapterID) === true) {
            return false;
        }

        if (empty($this->assignment) == false) {
            foreach ($this->assignment as $assignment) {
                if (empty($assignment) === false) {
                    if ($assignment['chapter_id'] == $chapterID) {
                        return $assignment;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Get the chapter ID of the specified assignment.
     *
     * @param $position
     *
     * @return bool|string
     */
    public function getAssignmentId($position = 'primary')
    {
        return $this->getIndividualAssignmentAttribute($position, 'chapter_id');
    }

    /**
     * Get the full information on the specified assignment.
     *
     * @param $position
     *
     * @return bool
     */
    public function getFullAssignmentInfo($position = 'primary')
    {
        if (isset($this->assignment) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty($assignment[$position]) === false) {
                    return $assignment;
                }
            }

            return false;
        } else {
            return false;
        }
    }

    /**
     * Return the specified attribute for the specified assignment or false if
     * it's not set.
     *
     * @param $position
     * @param $attr
     *
     * @return bool|string
     */
    private function getIndividualAssignmentAttribute($position, $attr)
    {
        $assignment = $this->getFullAssignmentInfo($position);
        if (empty($assignment[$attr]) === true) {
            return false;
        }

        return $assignment[$attr];
    }

    /**
     * Get the primary assignment chapter id.
     *
     * @deprecated
     *
     * @return bool|string
     */
    public function getPrimaryAssignmentId()
    {
        // Maintain backward compatibility

        return $this->getAssignmentId('primary');
    }

    /**
     * Get the secondary assignment chapter id.
     *
     * @deprecated
     *
     * @return bool|string
     */
    public function getSecondaryAssignmentId()
    {
        // Maintain backward compatibility

        return $this->getAssignmentId('secondary');
    }

    /**
     * Get the chapter name of the designated assignment.
     *
     * @param $position
     *
     * @return bool|mixed
     */
    public function getAssignmentName($position = 'primary')
    {
        return $this->getChapterAssignmentAttribute($position, 'chapter_name');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getPrimaryAssignmentName()
    {
        // Maintain backward compatibility

        return $this->getAssignmentName('primary');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getSecondaryAssignmentName()
    {
        // Maintain backward compatibility

        return $this->getAssignmentName('secondary');
    }

    /**
     * Get the hull number/designator for the specified assignment.
     *
     * @param $position
     *
     * @return bool|mixed
     */
    public function getAssignmentDesignation($position = 'primary')
    {
        return $this->getChapterAssignmentAttribute($position, 'hull_number');
    }

    /**
     * Get the chapter type for the designated assignment.
     *
     * @param $position
     *
     * @return bool|mixed
     */
    public function getAssignmentType($position = 'primary')
    {
        return $this->getChapterAssignmentAttribute($position, 'chapter_type');
    }

    /**
     * Get the specified attribute of the specified assignment.
     *
     * @param $position
     * @param $attribute
     *
     * @return bool|mixed
     */
    private function getChapterAssignmentAttribute($position, $attribute)
    {
        $chapter = Chapter::find($this->getAssignmentId($position));
        if (empty($chapter) === false) {
            return $chapter->$attribute;
        } else {
            return false;
        }
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getPrimaryAssignmentDesignation()
    {
        // Maintain backward compatibility

        return $this->getAssignmentDesignation('primary');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getSecondaryAssignmentDesignation()
    {
        // Maintain backward compatibility

        return $this->getAssignmentDesignation('secondary');
    }

    /**
     * Get the billet for the specified assignment.
     *
     * @param $position
     *
     * @return bool|string
     */
    public function getBillet($position = 'primary')
    {
        return $this->getIndividualAssignmentAttribute($position, 'billet');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getPrimaryBillet()
    {
        // Maintain backward compatibility

        return $this->getBillet('primary');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getSecondaryBillet()
    {
        // Maintain backward compatibility

        return $this->getBillet('secondary');
    }

    /**
     * Get the date assigned to the specified assignment.
     *
     * @param $position
     *
     * @return bool|string
     */
    public function getDateAssigned($position = 'primary')
    {
        return $this->getIndividualAssignmentAttribute(
            $position,
            'date_assigned'
        );
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getPrimaryDateAssigned()
    {
        // Maintain backward compatibility

        return $this->getDateAssigned('primary');
    }

    /**
     * @deprecated
     *
     * @return bool|mixed
     */
    public function getSecondaryDateAssigned()
    {
        // Maintain backward compatibility

        return $this->getDateAssigned('secondary');
    }

    /**
     * Get the billet for this user for the specified chapter.
     *
     * @param $chapterId
     *
     * @return bool
     */
    public function getBilletForChapter($chapterId)
    {
        if (isset($this->assignment) == true) {
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

    /**
     * Get a users time in grade.
     *
     * @TODO Refactor to use Carbon
     *
     * @param null|bool|string $short
     *
     * @return int|null|string
     *
     * @throws \Exception
     */
    public function getTimeInGrade($short = null)
    {
        if (empty($this->rank['date_of_rank']) === false) {
            $dorObj = new DateTime();
            list(
                $year, $month, $day) =
                explode('-', $this->rank['date_of_rank']);
            $dorObj->setDate($year, $month, $day);

            $timeInGrade = $dorObj->diff(new DateTime('now'));

            if (is_null($short) === false) {
                $years = $timeInGrade->format('%y');
                $months = $timeInGrade->format('%m');

                if ($timeInGrade->format('%d') > 25) {
                    $months += 1;
                    if ($months > 11) {
                        $years += 1;
                        $months = 0;
                    }
                }
                if ($short === true) {
                    return $years < 1 ? $months.' Mo' :
                        $years.' Yr '.$months.' Mo';
                } elseif ($short === 'months') {
                    return ($years * 12) + $months;
                }
            } else {
                return $timeInGrade->format('%y Year(s), %m Month(s), %d Day(s)');
            }
        } else {
            return;
        }
    }

    /**
     * Get Time in Service formated per the options provided.
     *
     * @param null $options
     *
     * @return int|null|string
     */
    public function getTimeInService($options = null)
    {
        $short = false;

        if (isset($options) === true && is_array($options) === false) {
            $short = $options;
        }

        if (empty($this->registration_date) === false) {
            $today = Carbon::today('America/New_York');

            $join = Carbon::createFromFormat('Y-m-d', $this->registration_date);

            $timeInService = $join->diff($today);

            if ($short === true) {
                $years = $timeInService->format('%y');
                $months = $timeInService->format('%m');
                if ($timeInService->format('%d') > 25) {
                    $months += 1;
                    if ($months > 11) {
                        $years += 1;
                        $months = 0;
                    }
                }

                return $years.' Yr '.$months.' Mo';
            }

            if (isset($options['format']) === true) {
                switch ($options['format']) {
                    case 'M':
                        return $join->diffInMonths($today);
                        break;
                    case 'Y':
                        return $join->diffInYears($today);
                        break;
                    case 'D':
                        return $join->diffInDays($today);
                        break;
                    case 'H':
                        return $join->diffInHours($today);
                        break;
                    case 'm':
                        return $join->diffInMinutes($today);
                        break;
                }
            }

            return $timeInService->format('%y Year(s), %m Month(s), %d Day(s)');
        } else {
            return;
        }
    }

    /**
     * Get a list of the users exams, potentially filtered by the provided
     * options.
     *
     * @param null $options
     *
     * @return array|mixed
     */
    public function getExamList($options = null)
    {
        $pattern = $except = $after = $since = $class = $onlyPassing = null;

        if (is_null($options) === false) {
            if (is_array($options) === false) {
                $pattern = $options; // backwards compatibility
            } else {
                if (empty($options['pattern']) === false) {
                    $pattern = $options['pattern'];
                }

                if (empty($options['after']) === false) {
                    $after = strtotime($options['after']);
                }

                if (empty($options['class']) === false) {
                    $class = $options['class'];
                }

                if (empty($options['since']) === false) {
                    $since = strtotime($options['since']);
                }

                if (empty($options['except']) === false) {
                    $except = $options['except'];
                }

                if (empty($options['onlyPassing']) === false) {
                    $onlyPassing = true;
                }
            }
        } else {
            $pattern = null;
        }

        $exams = Exam::where('member_id', '=', $this->member_id)->first();

        if (empty($exams) === false) {
            if (is_null($pattern) === true) {
                $list = $exams->exams;
            } else {
                // filter by pattern
                $list = $this->filterArray($exams->exams, $pattern);
            }

            // Exclude the indicated exams
            if (empty($except) === false) {
                $list = $this->filterArrayInverse($list, $except);
            }

            if ($onlyPassing === true) {
                // Only return exams with a passing grade
                $list = Arr::where($list, function ($value, $key) {
                    return $this->isPassingGrade($value['score']);
                });
            }

            if (empty($after) === false) {
                // filter by date
                $list = Arr::where(
                    $list,
                    function ($value, $key) use ($after) {
                        if (strtotime($value['date']) >= $after &&
                            strtotime($value['date']) < strtotime(
                                '+2 month',
                                $after
                            )
                        ) {
                            return true;
                        }

                        return false;
                    }
                );
            }

            if (empty($since) === false) {
                // Filter by date entered
                $list = Arr::where(
                    $list,
                    function ($value, $key) use ($since) {
                        if (empty($value['date_entered']) === true) {
                            return false;
                        }

                        if (strtotime($value['date_entered']) >= $since) {
                            return true;
                        }

                        return false;
                    }
                );
            }

            if (empty($class) === false) {
                //filter by class of exams
                // TODO: Put these patterns in the config table
                switch ($class) {
                    case 'enlisted':
                        //handle enlisted exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-000[1-9]$/';

                        $list = $this->filterArray($list, $examMatch);
                        break;

                    case 'warrant':
                        //handle warrant exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-001[1-9]$/';

                        $list = $this->filterArray($list, $examMatch);
                        break;

                    case 'officer':
                        //handle officer exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-01[0-9][1-9]$/';

                        $list = $this->filterArray($list, $examMatch);
                        break;

                    case 'flag':
                        //handle flag exams
                        $examMatch = '/^.*-(RMN|GSN|RHN|IAN)-100[1-9]$/';

                        $list = $this->filterArray($list, $examMatch);
                        break;

                    case 'officer+flag':
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

    /**
     * Get the highest exam from the list of exams provided.
     *
     * @param array $list
     *
     * @return array
     */
    private function getHighestExamFromList(array $list)
    {
        if (count($list) < 1) {
            return [];
        }

        krsort($list);

        return [key($list) => array_shift($list)];
    }

    /**
     * Get the highest main line exam for the users branch.
     *
     * @param null|string $class
     *
     * @return int|null|string
     */
    public function getHighestMainLineExamForBranch($class = null)
    {
        switch ($this->branch) {
            case 'CIVIL':
                if ($this->getRate() == 'INTEL') {
                    $college = 'KC';
                } else {
                    $college = 'QC';
                }
                $options['pattern'] = '/^.*-'.$college.'-.*/';
                $options['except'] = '/^.*-'.$college.'-0113|^.*-'.$college.'-0115/';
                break;
            default:
                $options['pattern'] = '/^.*-'.$this->branch.'-.*/';
                $options['except'] = '/^.*-'.$this->branch.'-0113|^.*-'.$this->branch.'-0115/';
        }

        if (empty($class) === false) {
            $options['class'] = $class;
        }

        $exams = $this->getExamList($options);

        // Special edge case for CIVIL branch members, check for SKU-CORE exams first

        if (count($exams) < 1 && $this->branch == 'CIVIL') {
            $options['pattern'] = '/^SKU-CORE-.*/';

            $exams = $this->getExamList($options);
        }

        // No exams found for branch, check RMN
        if (count($exams) < 1) {
            $options['pattern'] = '/^SIA-RMN-.*/';
            $options['except'] = '/^SIA-RMN-0113|^SIA-RMN-0115/';

            $exams = $this->getExamList($options);
        }

        $results = $this->getHighestExamFromList($exams);

        return key($results);
    }

    /**
     * Retrieve the highest level Enlisted exam a user has taken.
     *
     * @return array $exam
     */
    public function getHighestEnlistedExam()
    {
        $exams = $this->getExamList(['class' => 'enlisted']);

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    /**
     * Get the highest Warrant Officer exam a user has taken.
     *
     * @return array
     */
    public function getHighestWarrantExam()
    {
        $exams = $this->getExamList(['class' => 'warrant']);

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    /**
     * Get the highest Officer exam a user has taken.
     *
     * @return array
     */
    public function getHighestOfficerExam()
    {
        $exams = $this->getExamList(['class' => 'officer+flag']);

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    /**
     * Get the highest Flag Officer exam a user has taken.
     *
     * @return array
     */
    public function getHighestFlagExam()
    {
        $exams = $this->getExamList(['class' => 'flag']);

        $results = $this->getHighestExamFromList($exams);

        return $results;
    }

    /**
     * Get the higest enlisted, warrant officer and officer (including flag)
     * exams taken by a member.
     *
     * @return array
     */
    public function getHighestExams()
    {
        $classes = ['enlisted', 'warrant', 'officer+flag'];

        $results = [];

        foreach ($classes as $class) {
            foreach ($this->getHighestExamFromList(
                $this->getExamList(['class' => $class])
            ) as $exam => $examData) {
                $results[ucfirst(substr($class, 0, 1))] = $exam;
            }
        }

        return $results;
    }

    /**
     * Get exams completed after the specified date.
     *
     * @param $after
     *
     * @return string
     */
    public function getCompletedExams($after)
    {
        $exams = $this->getExamList(['after' => $after]);

        $list = Arr::where(
            $exams,
            function ($value, $key) use ($after) {
                if (intval($value['score']) > 70 ||
                    strtoupper($value['score'] == 'PASS')) {
                    return $value;
                }

                return false;
            }
        );

        return implode(', ', array_keys($list));
    }

    /**
     * Get the date of the last update for exams.
     *
     * @return bool|mixed
     */
    public function getExamLastUpdated()
    {
        $exams = Exam::where('member_id', '=', $this->member_id)->first();

        if (isset($exams) === true) {
            return $exams['updated_at'];
        } else {
            return false;
        }
    }

    /**
     * Does the user have new exams.
     *
     * @param string|null $regex
     *
     * @return bool
     */
    public function hasNewExams($regex = null)
    {
        $options['since'] = Auth::user()->getLastLogin();

        if (is_null($regex) === false) {
            $options['pattern'] = $regex;
        }

        if (count($this->getExamList($options)) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Give a user the standard set of CO permissions.
     *
     * @return bool
     */
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

    /**
     * Give a user all permissions.
     *
     * @return bool
     */
    public function assignAllPerms()
    {
        $this->updatePerms(['ALL_PERMS']);

        return true;
    }

    /**
     * Give a user perms used by BuShip.
     *
     * @return bool
     */
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

    /**
     * Give a user the perms used by BuPers.
     *
     * @return bool
     */
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

    /**
     * Give a user Space Lord perms.
     *
     * @return bool
     */
    public function assignSpaceLordPerms()
    {
        $this->assignCoPerms();
        $this->updatePerms(['VIEW_CHAPTER_REPORTS']);

        return true;
    }

    /**
     * Update a users permissions.
     *
     * @TODO Refactor to use a try / catch
     *
     * @param array $perms
     *
     * @return bool
     */
    public function updatePerms(array $perms)
    {
        $this->permissions =
            array_unique(array_merge($this->permissions, $perms));

        if (is_null(Auth::user())) {
            $user = 'system user';
        } else {
            $user = (string) Auth::user()->id;
        }

        $this->osa = false;

        $this->lastUpdate = time();

        $this->writeAuditTrail(
            $user,
            'update',
            'users',
            (string) $this->id,
            json_encode($this->permissions),
            'User@updatePerms'
        );

        $this->save();

        return true;
    }

    /**
     * Delete a permissions from a user.
     *
     * @TODO Refactor to use try / catch
     *
     * @param $perm
     *
     * @return bool
     */
    public function deletePerm($perm)
    {
        $this->permissions = Arr::where(
            $this->permissions,
            function ($value, $key) use ($perm) {
                return $value != $perm;
            }
        );

        if (is_null(Auth::user())) {
            $user = 'system user';
        } else {
            $user = (string) Auth::user()->id;
        }

        $this->osa = false;
        $this->lastUpdate = time();

        $this->writeAuditTrail(
            $user,
            'update',
            'users',
            (string) $this->id,
            json_encode($this->permissions),
            'User@deletePerms'
        );

        $this->save();

        return true;
    }

    /**
     * Delete a peerage from a users record.
     *
     * @param $peerage_id
     *
     * @return bool
     */
    public function deletePeerage($peerage_id)
    {
        $peerages = Arr::where(
            $this->peerages,
            function ($value, $key) use ($peerage_id) {
                if ($value['peerage_id'] != $peerage_id) {
                    return true;
                }

                return false;
            }
        );

        $this->peerages = $peerages;
        $this->lastUpdate = time();

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

    /**
     * Build the ID card png.
     *
     * @param bool $showFullGrade
     *
     * @return \Intervention\Image\Image
     */
    public function buildIdCard($showFullGrade = false)
    {
        $idCard =
            Image::make(public_path().'/images/TRMN-membership-card.png');

        $name = $this->getFullName();
        $fontSize = strlen($name) < 28 ? 48 : 38;

        $idCard->text(
            $name,
            382,
            330,
            function ($font) use ($fontSize) {
                $font->file(
                    public_path().
                    '/fonts/24bd1ba4-1474-491a-91f2-a13940159b6d.ttf'
                );
                $font->size($fontSize);
                $font->align('center');
            }
        );

        $idCard->text(
            $this->getAssignmentName('primary'),
            382,
            432,
            function ($font) {
                $font->file(
                    public_path().
                    '/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf'
                );
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
                $font->file(
                    public_path().
                    '/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf'
                );
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
                    case 'SFC':
                        $rankCode .= '-SFC';
                        break;
                    case 'CIVIL':
                        switch ($this->rating) {
                            case 'INTEL':
                                $rankCode .= '-IS';
                                break;
                            case 'DIPLOMATIC':
                                $rankCode .= '-CD';
                                break;
                            case 'LORDS':
                                if ($this->rank['grade'] == 'C-20' || $this->rank['grade'] == 'C-22') {
                                    $rankCode .= '-MP';
                                } else {
                                    $rankCode .= '-LS';
                                }
                                break;
                            case 'COMMONS':
                                if ($this->rank['grade'] == 'C-20' || $this->rank['grade'] == 'C-22') {
                                    $rankCode .= '-MP';
                                } else {
                                    $rankCode .= '-CS';
                                }
                                break;
                        }
                }
                break;
            default:
                break;
        }

        switch ($this->branch) {
            case 'RMACS':
            case 'CIVIL':
                $seal = 'CIV.png';
                if ($this->rating == 'INTEL') {
                    $seal = 'INTEL.png';
                }
                break;
            case 'RMMM':
                $seal = 'RMMM.png';
                break;
            case 'SFC':
                $seal = 'SFC.png';
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
                $font->file(
                    public_path().
                    '/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf'
                );
                $font->align('center');
                $font->size(40);
                $font->color('#BE1E2D');
            }
        );

        $peerages = $this->getPeerages();

        if (empty($peerages) === false) {
            $pCode = $peerages[0]['code'];

            if ($pCode == 'K' && substr(
                Korders::where(
                    'classes.postnominal',
                    '=',
                    $peerages[0]['postnominal']
                )->first()->getClassName(
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
                    $font->file(
                        public_path().
                        '/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf'
                    );
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
                $font->file(
                    public_path().
                    '/fonts/cfaa819f-cd58-49ce-b24e-99bbb04fa859.ttf'
                );
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
                $font->file(
                    public_path().
                    '/fonts/de9a96b8-d3ad-4521-91a2-a44556dab791.ttf'
                );
                $font->align('center');
                $font->size(20);
            }
        );

        $idCard->insert(
            base64_encode(
                QrCode::format('png')
                      ->margin(1)
                      ->size(150)
                      ->errorCorrection('H')
                      ->generate($this->member_id)
            ),
            'top-left',
            780,
            252
        );

        $idCard->insert(
            public_path().'/seals/'.$seal,
            'top-left',
            747,
            400
        );

        return $idCard;
    }

    /**
     * Try and standardize and normalize State and Province.
     *
     * @param $state
     *
     * @return string
     */
    public static function normalizeStateProvince($state)
    {
        if (strlen($state) == 2) {
            /* No need to validate, we don't know all 2 letter state and province abbreviations */
            return strtoupper($state);
        }

        if (strlen($state) == 3 && substr($state, -1) == '.') {
            // We have a 2 letter abbreviation followed by a period.  Strip the period and slam to upper case
            return strtoupper(substr($state, 0, 2));
        }

        if (strlen($state) == 4 && substr($state, -1) == '.' && substr(
            $state,
            -3,
            1
        ) == '.'
        ) {
            // We have a 2 letter abbreviation with periods between the letters, like D.C. or B.C.
            return strtoupper(substr($state, 0, 1).substr($state, -2, 1));
        }

        if (substr($state, 2, 2) == ' -') {
            // We may have a 2 letter abbreviation followed by the full name, try and validate
            if (array_key_exists(
                strtoupper(substr($state, 0, 2)),
                MedusaDefaults::STATES_BY_ABREVIATION
            ) === true
            ) {
                return strtoupper(substr($state, 0, 2));
            }
        }

        // Nothing else hits, check and see if we know the 2 letter abbreviation

        if (array_key_exists(
            strtoupper($state),
            MedusaDefaults::STATES_BY_NAME
        ) === true
        ) {
            $tmp = MedusaDefaults::STATES_BY_NAME;

            return $tmp[strtoupper($state)];
        }

        // No hits, return it un altered

        return $state;
    }

    /**
     * Determine the next highest member id.
     *
     * @TODO Refactor
     *
     * @return string
     */
    public static function getNextAvailableMemberId()
    {
        $lastMemberId = self::getMemberIds();

        if (empty($lastMemberId) === true) {
            return '-0001-'.date('y');
        }

        $newNumber = $lastMemberId + 1;

        if ($newNumber > 9999) {
            $newNumber = 0;
        }

        $newNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $yearCode = date('y');

        return "-$newNumber-$yearCode";
    }

    /**
     * Find the lowest unused member id.
     *
     * @deprecated Operation too expensive. Will now return the next available member id.
     *
     * @param bool $honorary
     *
     * @return string
     */
    public static function getFirstAvailableMemberId($honorary = false)
    {
        return self::getNextAvailableMemberId();
    }

    /**
     * Return all member id's.
     *
     * @return array
     */
    public static function getMemberIds()
    {
        return intval(substr(self::max('member_id'), 4, 4));
    }

    /**
     * Get email address for reminder emails.
     *
     * @return mixed
     */
    public function getReminderEmail()
    {
        return $this->email_address;
    }

    /**
     * Get field to use for authetication.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get password for user, used by auth routines.
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Update a users last login.
     */
    public function updateLastLogin()
    {
        $this->previous_login = $this->last_login;
        $this->last_login = date('Y-m-d H:i:s');
        $this->save();
    }

    /**
     * Get last login date.
     *
     * @return false|string
     */
    public function getLastLogin()
    {
        if (empty($this->previous_login) === true) {
            return date('Y-m-d', strtotime('-2 weeks'));
        }

        return date('Y-m-d', strtotime($this->previous_login));
    }

    /**
     * Get the date the users record was last updated.
     *
     * @return int
     */
    public function getLastUpdated()
    {
        if (empty($this->lastUpdate) == true) {
            return strtotime($this->updated_at->toDateTimeString());
        }

        return $this->lastUpdate;
    }

    /**
     * Update the last updated field.
     */
    public function updateLastUpdated()
    {
        $this->lastUpdate = time();
        $this->save();
    }

    /**
     * Check all rosters that a user has access to for new exams.
     *
     * @return bool
     */
    public function checkRostersForNewExams()
    {
        if ($this->id != Auth::user()->id ||
            empty($this->duty_roster) === true) {
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

    /**
     * Get events that the user is a requestor or registrar.
     *
     * @param null $continent
     * @param null $city
     *
     * @return array
     */
    public function getScheduledEvents($continent = null, $city = null)
    {
        $currentTz = $this->setTimeZone($continent, $city);

        $events =
            Events::where('start_date', '<=', date('Y-m-d'))
                  ->where('end_date', '>=', date('Y-m-d'))
                  ->where(
                      function ($query) {
                          $query->where('requestor', '=', $this->id)
                                ->orWhere('registrars', '=', $this->id);
                      }
                  )
                  ->orderBy('start_date', 'ASC')
                  ->get(['id', 'event_name']);

        $this->setTimeZone($currentTz);

        return $events->toArray();
    }

    /**
     * Check a member in to an event.
     *
     * @param $event
     * @param $member
     * @param null $continent
     * @param null $city
     *
     * @return array
     */
    public function checkMemberIn(
        $event,
        $member,
        $continent = null,
        $city = null
    ) {
        $currentTz = $this->setTimeZone($continent, $city);

        // Event sanity checks
        if (is_object($event) === false) {
            // If it's not an object, instantiate an event object
            try {
                $event = Events::find($event);
            } catch (Exception $e) {
                $this->setTimeZone($currentTz);

                return ['error' => 'Invalid Event id'];
            }
        }

        if (is_a($event, \App\Events::class) === false) {
            // Not the correct object, return an error
            $this->setTimeZone($currentTz);

            return ['error' => 'Invalid Event object'];
        }

        // Find the user being checked in

        try {
            $user =
                self::where('member_id', '=', $member)
                    ->where('registration_status', '=', 'Active')
                    ->where('active', '=', 1)
                    ->firstOrFail();
        } catch (Exception $e) {
            $this->setTimeZone($currentTz);

            return ['error' => 'Invalid Member ID'];
        }

        // Are we within the dates of the event?

        if ($event->start_date <= date('Y-m-d') &&
            $event->end_date >= date('Y-m-d')) {
            // Is the user doing the check-in a requestor or a registrar?
            if ($event->requestor === $this->id || in_array(
                $this->id,
                $event->registrars
            ) === true) {
                $checkIns = [];
                if (isset($event->checkins) === true) {
                    $checkIns = $event->checkins;
                }
                if (in_array($user->id, $checkIns) === false) {
                    // Only check them in once
                    $checkIns[] =
                        ['id' => $user->id, 'timestamp' => date('Y-m-d H:m:s')];
                    //$checkIns[] = $user->id;
                    $event->checkins = $checkIns;
                }

                try {
                    $event->save();

                    $this->writeAuditTrail(
                        $this->id,
                        'update',
                        'events',
                        null,
                        $event->toJson(),
                        'User@checkMemberIn'
                    );

                    $this->setTimeZone($currentTz);

                    return ['success' => $user->getFullName().
                                         ' has been checked in to '.
                                         $event->event_name, ];
                } catch (Exception $e) {
                    $this->setTimeZone($currentTz);

                    return ['error' => 'There was a problem checking '.
                                       $user->getFullName().' in to '.
                                       $event->event_name, ];
                }
            }
        } else {
            $this->setTimeZone($currentTz);

            return ['error' => 'The event has not started or is over'];
        }

        return ['error' => 'There was a problem checking this member in'];
    }

    /**
     * Set the timezone.
     *
     * @param null $continent
     * @param null $city
     *
     * @return null|string
     */
    private function setTimeZone($continent = null, $city = null)
    {
        if (is_null($continent) === false) {
            // Optional TZ provided, save the current tz
            $currentTz = date_default_timezone_get();
            if (is_null($city) === true) {
                // $continent has the full tz spec
                date_default_timezone_set($continent);
            } else {
                date_default_timezone_set($continent.'/'.$city);
            }

            return $currentTz;
        }
    }

    /**
     * Find a members record by their member_id.
     *
     * @param $memberId
     *
     * @return User
     */
    public static function getUserByMemberId($memberId)
    {
        return self::where('member_id', '=', $memberId)->firstOrFail();
    }

    /**
     * Get the members current awards, account for awards due to issued in the
     * future.
     *
     * @return array
     */
    public function getCurrentAwards()
    {
        $awards = [];

        $today = Carbon::today('America/New_York');

        foreach ($this->awards as $code => $award) {
            foreach ($award['award_date'] as $date) {
                $awardDate = Carbon::createFromFormat('Y-m-d H', $date.' 0')
                                   ->addDays(config('awards.display_days'));

                if ($today->lt($awardDate)) {
                    // Reduce the count by one, the date of this award instance + 2 days is still in the future
                    $award['count']--;
                }
            }

            if ($award['count'] > 0) {
                $award['award_date'] = array_slice(
                    $award['award_date'],
                    0,
                    $award['count']
                );
                $awards[$code] = $award;
            }
        }

        return $awards;
    }

    /**
     * Get the ribbons for a specific location.
     *
     * @param string $location
     *
     * @return array
     */
    public function getRibbons($location = 'L')
    {
        $tmp = [];

        $today = Carbon::today('America/New_York');

        foreach ($this->awards as $code => $award) {
            $onDisk = true;

            if (($location == 'L' || $location == 'R') &&
                file_exists(public_path('/ribbons/'.$code.'-1.svg')) ===
                false) {
                $onDisk = false;
            }

            if ($award['location'] === $location && $award['display'] === true &&
                $onDisk === true) {
                // Check for awards that haven't been given yet, adjust count as needed

                foreach ($award['award_date'] as $date) {
                    $awardDate =
                        Carbon::createFromFormat('Y-m-d H', $date.' 0')
                              ->addDays(config('awards.display_days'));

                    if ($today->lt($awardDate)) {
                        // Reduce the count by one, the date of this award instance + 2 days is still in the future
                        $award['count']--;
                    }
                }

                $award['code'] = $code;
                $award['name'] = Award::getAwardName($code);
                $award['points'] = Award::getPointsForAward($code);

                if ($award['count'] > 0) {
                    $tmp[Award::getDisplayOrder($code)] = $award;
                }
            }
        }

        ksort($tmp);

        $awards = [];
        $count = 1;

        foreach ($tmp as $ribbon) {
            $awards[$count] = $ribbon;
            $count++;
        }

        return $awards;
    }

    /**
     * Does the member have awards?
     *
     * @return bool
     */
    public function hasAwards()
    {
        if (count($this->awards) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Get patch to shoulder patch for the specified assignment.
     *
     * @param string $assignment
     *
     * @return bool|string
     */
    public function getUnitPatchPath($assignment = 'primary')
    {
        $chapter = Chapter::find($this->getAssignmentId($assignment));

        if (is_null($chapter) === true) {
            return false;
        }

        switch ($chapter->chapter_type) {
            case 'small_craft':
            case 'section':
            case 'squad':
            case 'platoon':
            case 'company':
            case 'battalion':
            case 'shuttle':
            case 'regiment':
            case 'exp_force':
            case 'corps':
                $chapters = [$chapter->assigned_to];
                break;
            case 'lac':
                $chapters = $chapter->getChapterIdWithParents('district');
                break;
            case 'fleet':
            case 'ship':
            case 'station':
            case 'bivouac':
            case 'outpost':
            case 'fort':
            case 'planetary':
            case 'theater':
            case 'task_force':
            case 'task_group':
            case 'squadron':
            case 'division':
            case 'headquarters':
            case 'bureau':
                $chapters = [$chapter->id];
                break;
            default:
                $chapters = $chapter->getChapterIdWithParents();
        }

        // Check to see if we have a patch for this chapter
        foreach ($chapters as $item) {
            $chapter = Chapter::find($item);
            $path = 'patches/'.$chapter->chapter_type.'/'.
                    (empty($chapter->branch) ||
                     $chapter->chapter_type == 'bureau' ? '' :
                        $chapter->branch.'/').trim($chapter->hull_number).
                    '.svg';

            if (file_exists(public_path($path)) === true) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Oauth find user.
     *
     * @param $username
     *
     * @return User
     */
    public function findForPassport($username)
    {
        return self::where(
            'email_address',
            '=',
            str_replace(' ', '+', strtolower($username))
        )->first();
    }

    /**
     * Check if a user has a specific award.
     *
     * @param string $awardAbbr
     *
     * @return bool
     */
    public function hasAward(string $awardAbbr)
    {
        return isset($this->awards[$awardAbbr]);
    }

    /**
     * Add or update an award.
     *
     * @TODO Add audit trail
     *
     * @param array $award
     *
     * @return bool
     */
    public function addUpdateAward(array $award)
    {
        foreach ($award as $awardCode => $awardInfo) {
            // Check that we have all the required fields in the info
            if (isset($awardInfo['count']) === false ||
                isset($awardInfo['location']) === false ||
                isset($awardInfo['award_date']) === false) {
                return false; // Invalid
            }

            $awards = $this->awards;
            $awards[$awardCode] = $awardInfo;
            $this->awards = $awards;

            return $this->save();
        }

        return false;
    }

    /**
     * Set a members career path.
     *
     * @param string $path
     *
     * @return bool
     */
    public function setPath(string $path)
    {
        $validPaths = ['line', 'staff', 'service'];

        $path = strtolower($path);

        if (in_array($path, $validPaths) === true) {
            try {
                $this->path = $path;

                $this->save();

                return true;
            } catch (\MongoException $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Set a promotion point key to the specified value.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function setPromotionPointValue(string $key, string $value)
    {
        $validKeys =
            [
                'triad', 'fleet', 'ah', 'cpm', 'cpe', 'che', 'cph', 'chh', 'vch',
                'con', 'ahcon', 'vcon', 'vahcon', 'mp', 'sh', 'ls', 'peerage',
            ];

        if (in_array($key, $validKeys) === true &&
            (is_numeric($value) === true ||
             in_array($value, ['B', 'E', 'S', 'D', 'G']) === true
            )) {
            // Valid promotion point key and is a number
            $points = $this->points;

            $points[$key] = $value;

            $this->points = $points;

            $this->save();

            return true;
        }

        return false;
    }

    /**
     * Get promotion points earned from awards.
     *
     * @return int
     */
    public function getPointsFromAwards()
    {
        $points = 0;
        $today = Carbon::today('America/New_York');

        if (empty($this->awards) === false) {
            foreach ($this->awards as $code => $award) {
                $awardInfo = Award::where('code', $code)->first(['points']);

                if ($awardInfo->points > 0) {
                    foreach ($award['award_date'] as $date) {
                        $awardDate =
                            Carbon::createFromFormat('Y-m-d H', $date.' 0')
                                  ->addDays(config('awards.display_days'));

                        if ($today->lt($awardDate)) {
                            // Reduce the count by one, the date of this award instance + 2 days is still in the future
                            $award['count']--;
                        }
                    }

                    $points += ($award['count'] * $awardInfo->points);
                }
            }
        }

        return $points;
    }

    /**
     * Get promotion points from Time in Service.
     *
     * @return int
     */
    public function getPointsFromTimeInService()
    {
        $today = Carbon::today('America/New_York');

        $join = Carbon::createFromFormat('Y-m-d', $this->registration_date);

        return intval($today->diffInMonths($join) / 3);
    }

    /**
     * Get promotion points from Exams.
     *
     * @return int|string
     */
    public function getPointsFromExams()
    {
        $numCompletedExams = count($this->getExamList(['onlyPassing' => true]));

        $examConfig = MedusaConfig::get('pp.exams', []);

        $pointsEarned = 0;

        foreach ($examConfig as $points => $patterns) {
            foreach ($patterns as $pattern) {
                $res = 0;

                foreach ($this->getExamList(['pattern' => $pattern, 'onlyPassing' => true]) as $exam) {
                    $res++;
                }

                if ($res > 0) {
                    $pointsForPattern = $res * $points;

                    $pointsEarned += $pointsForPattern;
                    $numCompletedExams -= $res;
                }
            }
        }

        $pointsEarned += $numCompletedExams;

        return $pointsEarned;
    }

    /**
     * Get total promotion points for a user.
     *
     * @return int
     */
    public function getTotalPromotionPoints()
    {
        $points = 0;

        $c = MedusaConfig::get('pp.form-config');

        $config = [];

        foreach ($c as $cat) {
            foreach ($cat as $item) {
                $config[$item['target']] = $item;
            }
        }

        if (empty($this->points) === false) {
            // Points stored on their record
            foreach ($this->points as $k => $v) {
                // Need to handle the points for peerages a little different
                if ($k === 'peerage') {
                    switch ($v) {
                        case 'B':
                            $points += 1;
                            break;
                        case 'E':
                            $points += 2;
                            break;
                        case 'S':
                            $points += 4;
                            break;
                        case 'L':
                            $points += 4;
                            break;
                        case 'D':
                            $points += 4;
                            break;
                        case 'G':
                            $points += 7;
                            break;
                    }
                } elseif ($k !== 'ep') {
                    $v = intval($v);
                    $itemConfig = $config[$k];

                    if ($itemConfig['class'] == 'pp-calc-3') {
                        // Points based on 3 month blocks of time
                        $v = intval($v / 3) * $itemConfig['points'];
                    } else {
                        $v = $v * $itemConfig['points'];
                    }

                    $points += $v;
                } else {
                    $points -= intval($v);
                }
            }
        }

        // Points from exams, awards and Tig
        $points += $this->getPointsFromAwards();
        $points += $this->getPointsFromExams();
        $points += $this->getPointsFromTimeInService();

        return $points;
    }

    /**
     * Get Overall GPA or for a specific school.
     *
     * @param string $pattern
     *
     * @return string|int
     */
    public function getGPA($pattern = '/.*/')
    {
        $exams = $this->getExamList(['pattern' => $pattern]);

        $numExams = count($exams);

        $sum = 0;

        foreach ($exams as $exam) {
            $score = rtrim(substr(strtoupper($exam['score']), 0, 4), '%');

            if ($score === 'PASS' || $score === 'BETA' || $score === 'CREA') {
                $score = '100';
            }

            $sum += is_numeric($score) ? $score : 100;
        }

        return $numExams !== 0 ? number_format($sum / $numExams, 2) : 'N/A';
    }

    /**
     * Get GPA for all the Schools.
     *
     * @param $service
     *
     * @return array
     */
    public function getGpaBySchool($service)
    {
        $servicePatterns = MedusaConfig::get('gpa.patterns', [], 'services');
        $coursePatterns = MedusaConfig::get('gpa.patterns', [], 'courses');

        $servicePattern = $servicePatterns[$service];
        $results = [];

        foreach ($coursePatterns as $course => $pattern) {
            $results[$course] = $this->getGPA($servicePattern.$pattern);

            if ($results[$course] === 0) {
                unset($results[$course]);
            }
        }

        return $results;
    }

    /**
     * Get the members service path.
     *
     * @return string
     */
    public function getPath()
    {
        return empty($this->path) === true ? 'service' : $this->path;
    }

    /**
     * Check if the user has the required exam for the specified exam pattern.
     *
     * @param array $exams
     *
     * @return bool
     */
    private function hasRequiredExams(array $exams)
    {
        $numFalse = 0;

        foreach ($exams as $exam) {
            $examMatches = $this->getExamList(['pattern' => '/^.*-'.$exam.'$/']);

            $passedExams = 0;

            foreach ($examMatches as $examInfo) {
                if ($this->isPassingGrade($examInfo['score']) === true) {
                    $passedExams++;
                }
            }

            if ($passedExams === 0) {
                $numFalse++;
            }
        }

        return $numFalse === 0;
    }

    /**
     * Add an entry to the users service history.
     *
     * @param array $entry
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function addServiceHistoryEntry(array $entry)
    {
        // Check for proper format
        if (empty($entry['timestamp']) === true ||
            empty($entry['event']) === true) {
            return false;
        }

        $history = $this->history;

        // Add the entry

        $history[] = $entry;

        if (empty($history) === false) {
            $history = array_values(
                Arr::sort(
                    $history,
                    function ($value) {
                        return $value['timestamp'];
                    }
                )
            );
        }

        $this->history = $history;

        try {
            $this->save();

            $this->writeAuditTrail(
                (string) Auth::user()->id,
                'update',
                'users',
                (string) $this->id,
                json_encode($this),
                'User@addServiceHistoryEntry'
            );

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get all active users.
     *
     * @return \App\User[]
     */
    public static function activeUsers()
    {
        return self::where('registration_status', 'Active')->where('active', 1)
                   ->get();
    }

    /**
     * Return an array of the base Army Weapons Qualification Badges.
     *
     * @return array
     */
    public function getArmyWeaponBadges()
    {
        $badges = [];

        foreach ($this->getRibbons('AWQ') as $badge) {
            $badges[$badge['points']] = basename(Award::getAwardImage($badge['code']), '.png');
        }

        krsort($badges);

        return $badges;
    }
}
