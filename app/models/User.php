<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;
use Medusa\Enums\MedusaDefaults;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    public static $rules = [
        'first_name'            => 'required|min:2',
        'last_name'             => 'required|min:2',
        'address1'             => 'required|min:4',
        'city'                  => 'required|min:2',
        'state_province'        => 'required|min:2',
        'postal_code'           => 'required|min:2',
        'country'               => 'required',
        'email_address'         => 'required|email|unique:users',
        'password'              => 'confirmed',
        'branch'                => 'required',
    ];

    public static $updateRules = [
        'first_name'            => 'required|min:2',
        'last_name'             => 'required|min:2',
        'address1'             => 'required|min:4',
        'city'                  => 'required|min:2',
        'state_province'        => 'required|min:2',
        'postal_code'           => 'required|min:2',
        'country'               => 'required',
        'email_address'         => 'required|email',
        'password'              => 'confirmed',
        'branch'                => 'required',
    ];

    public static $error_message = [
        'min'                            => 'The members :attribute must be at least :min characters long',
        'address1.required'             => 'Please enter the members street address',
        'address1.min'                  => 'The street address must be at least :size characters long',
        'required'                       => 'Please enter the members :attribute',
        'state_province.required'        => 'Please enter the members state or province',
        'state_province.min'             => 'The members state or province must be at least :size character long',
        'date_format'                    => 'Please enter a date in the format YYYY-MM-DD',
        'branch.required'                => "Please select the members branch",
        'email_address.unique'           => 'That email address is already in use',
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
        'peerage_record',
        'awards',
        'password',
        'permissions',
        'duty_roster',
        'registration_status',
    ];

    public function announcements()
    {
        return $this->hasMany('Announcement');
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

            if (isset($rateGreeting) === true && empty($rateGreeting) === false) {
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

        if (empty($this->branch) === true) {
            $this->branch = 'RMN';
        }

        $this->rank_title = $gradeDetails->rank[$this->branch];

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
                ['rate'        => $currentRating,
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

        return '';
    }

    public function getPrimaryAssignmentId()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
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

    public function getSecondaryAssignmentId()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty($assignment['primary']) === true ||
                    $assignment['primary'] == false) {
                        if (empty( $assignment['chapter_id'])) return false;
                        return $assignment['chapter_id'];
                }
            }

            return false;
        } else {
            return false;
        }
    }

    public function getPrimaryAssignmentName()
    {
        $chapter = Chapter::find($this->getPrimaryAssignmentId());
        if (!empty( $chapter )) {
            return $chapter->chapter_name;
        } else {
            return false;
        }
    }

    public function getSecondaryAssignmentName()
    {
        $chapter = Chapter::find($this->getSecondaryAssignmentId());
        if (!empty( $chapter )) {
            return $chapter->chapter_name;
        } else {
            return false;
        }
    }

    public function getPrimaryAssignmentDesignation()
    {
        $chapter = Chapter::find($this->getPrimaryAssignmentId());
        if (!empty( $chapter )) {
            return $chapter->hull_number;
        } else {
            return false;
        }
    }

    public function getSecondaryAssignmentDesignation()
    {
        $chapter = Chapter::find($this->getSecondaryAssignmentId());
        if (!empty( $chapter )) {
            return $chapter->hull_number;
        } else {
            return false;
        }
    }

    public function getPrimaryBillet()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
                    return $assignment['billet'];
                }
            }

            return '';
        } else {
            return '';
        }
    }

    public function getSecondaryBillet()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty( $assignment['primary'] ) === true || $assignment['primary'] == false) {
                    return $assignment['billet'];
                }
            }

            return '';
        } else {
            return '';
        }
    }

    public function getPrimaryDateAssigned()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
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

    public function getSecondaryDateAssigned()
    {
        if (isset( $this->assignment ) == true) {
            foreach ($this->assignment as $assignment) {
                if (empty( $assignment['primary'] ) === true || $assignment['primary'] == false) {
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

    public function getTimeInGrade() {
        if (empty($this->rank['date_of_rank']) === false) {
            $dorObj = new DateTime(date('Y-m-d', strtotime($this->rank['date_of_rank'])));
            $timeInGrade = $dorObj->diff(new DateTime("now"));
            return $timeInGrade->format('%y Year(s), %m Month(s), %d Day(s)');
        } else {
            return null;
        }

    }

    public function getTimeInService() {
        if (empty($this->registration_date) === false) {
            $regDateObj = new DateTime(date('Y-m-d', strtotime($this->registration_date)));
            $timeInService = $regDateObj->diff(new DateTime("now"));
            return $timeInService->format('%y Year(s), %m Month(s), %d Day(s)');
        } else {
            return null;
        }

    }

    public function getExamList(){
        $exams = Exam::where('member_id', '=', $this->member_id)->get();

        if (isset($exams[0]) === true) {
            $list = $exams[0]['exams'];
            ksort($list);
            return $list;
        } else {
            return [];
        }
    }

    public function getExamLastUpdated() {
        $exams = Exam::where('member_id', '=', $this->member_id)->get();

        if (isset( $exams[0] ) === true) {
            return $exams[0]['updated_at'];
        } else {
            return false;
        }
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
            ]);

        return true;
    }

    public function assignAllPerms()
    {
        $this->updatePerms(['ALL_PERMS']);

        return true;
    }

    public function assignBuShipPerms()
    {
        $this->updatePerms([
            'COMMISSION_SHIP',
            'DECOMMISSION_SHIP',
            'EDIT_SHIP',
            'VIEW_DSHIPS',
            'VIEW_SU',
        ]);

        return true;
    }

    public function assignBuPersPerms()
    {
        $this->updatePerms([
            'ADD_MEMBER',
            'DEL_MEMBER',
            'EDIT_MEMBER',
            'VIEW_MEMBERS',
            'PROC_APPLICATIONS',
            'PROC_XFERS',
            'ADD_BILLET',
            'DEL_BILLET',
            'EDIT_BILLET',]);

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

        $this->save();

        return true;
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

    static function getFirstAvailableMemberId($honorary=false)
    {
        $uniqueMemberIds = self::_getMemberIds();

        if (sizeof($uniqueMemberIds) == 0) {
            return "-0000" . date('y');
        }

        asort($uniqueMemberIds);

        $lastId = 0;

        foreach ($uniqueMemberIds as $memberId) {
            if ((intval($lastId) + 1 < intval($memberId)) && ($honorary === true || intval($lastId) + 1 > 200)) {
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
}
