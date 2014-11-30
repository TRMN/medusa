<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Jenssegers\Mongodb\Model as Eloquent;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    public static $rules = [
        'member_id' => 'required|size:11|unique:users',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'address_1' => 'required|min:4',
        'city' => 'required|min:2',
        'state_province' => 'required|min:2',
        'postal_code' => 'required|min:2',
        'country' => 'required',
        'email_address' => 'required|email|unique:users',
        'password' => 'confirmed',
        'branch' => 'required',
        'perm_dor' => 'date|date_format:Y-m-d|required_with:permanent_rank',
        'brevet_dor' => 'date|date_format:Y-m-d|required_with:brevet_rank',
        'primary_assignment' => 'required',
        'primary_date_assigned' => 'required|date|date_format:Y-m-d'
    ];

    public static $updateRules = [
        'member_id' => 'required|size:11',
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'address_1' => 'required|min:4',
        'city' => 'required|min:2',
        'state_province' => 'required|min:2',
        'postal_code' => 'required|min:2',
        'country' => 'required',
        'email_address' => 'required|email',
        'password' => 'confirmed',
        'branch' => 'required',
        'perm_dor' => 'date|date_format:Y-m-d|required_with:permanent_rank',
        'brevet_dor' => 'date|date_format:Y-m-d|required_with:brevet_rank',
        'primary_assignment' => 'required',
        'primary_date_assigned' => 'required|date|date_format:Y-m-d'
    ];

    public static $error_message = [
        'member_id.required' => 'A Member ID is required',
        'member_id.size' => 'The Member ID must follow the format RMN-XXXX-YY',
        'member_id.unique' => 'That member ID is already in use',
        'min' => 'The members :attribute must be at least :min characters long',
        'address_1.required' => 'Please enter the members street address',
        'address_1.min' => 'The street address must be at least :size characters long',
        'required' => 'Please enter the members :attribute',
        'state_province.required' => 'Please enter the members state or province',
        'state_province.min' => 'The members state or province must be at least :size character long',
        'perm_dor.required_with' => 'If a permanent rank has been selected, a date of rank must be entered',
        'perm_dor.date' => 'The permanent date of rank must be a valid date',
        'brevet_dor.required_with' => 'If a brevet rank has been selected, a date of rank must be entered',
        'brevet_dor.date' => 'The permanent date of rank must be a valid date',
        'date_format' => 'Please enter a date in the format YYYY-MM-DD',
        'primary_assignment.required' => "Please select the members primary chapter assignment",
        'primary_date_assigned.required' => 'Please enter the date the member was assigned to their primary chapter',
        'branch.required' => "Please select the members branch",
        'email_address.unique' => 'That email address is already in use',
    ];

    protected $hidden = [ 'password', 'remember_token' ];

    protected $fillable = [ 'member_id', 'first_name', 'middle_name', 'last_name', 'suffix', 'address_1', 'address_2', 'city', 'state_province', 'postal_code', 'country', 'phone_number', 'email_address', 'branch', 'rating', 'rank', 'assignment', 'peerage_record', 'awards_record', 'exam_record', 'password' ];

    public function announcements() {
        return $this->hasMany( 'Announcement' );
    }

    /**
     * Return only the preferred rank title for a user
     *
     * @return mixed
     */
    public function getGreeting() {
        $this->getDisplayRank();

        $displayRank = $this->perm_display;

        if ( isset( $this->rating ) && !empty( $this->rating ) ) {

            if ( $rateGreeting = $this->getRateTitle( $displayRank ) ) {
                $displayRank = $rateGreeting;
            }
        }
        if( isset( $this->brevet_rank ) && !empty( $this->brevet_rank ) ) {
            $displayRank = $this->brevet_display;
        }

        return $displayRank;
    }

    public function getGreetingArray() {
        $this->getDisplayRank();

        $rank = $this->perm_display;

        if ( isset( $this->rating ) && !empty( $this->rating ) ) {

            if ( $rateGreeting = $this->getRateTitle( $rank ) ) {
                $greeting[ 'rank' ] = $rateGreeting;
            }
        }
        if( isset( $this->brevet_rank ) && !empty( $this->brevet_rank ) ) {
            $rank = $this->brevet_display;
        }

        $greeting[ 'rank' ] = $rank;
        // To be used when viewing an announcement not published by the current user
        $greeting[ 'last_name' ] = $this->last_name;
        //To link to the user who published an announcement
        $greeting[ 'user_id' ] = $this->user_id;

        return $greeting;
    }

    /**
     * Set permanent rank, brevet rank and rating in one place
     */
    public function getDisplayRank() {
        $ranks = [ 'perm' => 'permanent_rank' , 'brevet' => 'brevet_rank' ];

        foreach( $ranks as $shortLabel => $rank ) {

            $displayVarName = $shortLabel . '_display';
            $dorVarName = $shortLabel . '_dor';

            $this->$rank = '';
            $this->$dorVarName = '';
            $this->$displayVarName = '';

            if( isset( $this->rank[ $rank ] ) && !empty( $this->rank[ $rank ] ) ) {

                $grade = $this->rank[ $rank ][ 'grade' ];

                $gradeDetails = Grade::where( 'grade', '=', $grade )->get();

                $this->$rank = $this->rank[ $rank ][ 'grade' ];
                $this->$displayVarName = $gradeDetails[ 0 ]->rank[ $this->branch ];
                $this->$dorVarName = $this->rank[ $rank ][ 'date_of_rank' ];
            }
        }

        if ( isset( $this->rating ) && !empty( $this->rating ) ) {
            $this->rating = [ 'rate' => $this->rating, 'description' => Rating::where( 'rate_code', '=', $this->rating )->get()[ 0 ]->rate[ 'description' ] ];
        }
    }

    /**
     * Get the rate specific rank title, if any
     *
     * @param $rank
     * @return mixed
     */
    function getRateTitle( $rank )
    {
        $rateDetail = Rating::where( 'rate_code', '=', $this->rating )->get();

        if ( isset( $rateDetail[ 0 ]->rate[ $this->branch ][ $rank ] ) === true && empty( $rateDetail[ 0 ]->rate[ $this->branch ][ $rank ] ) === false ) {
            return $rateDetail[ 0 ]->rate[ $this->branch ][ $rank ];
        }

        return false;
    }

    public function getPrimaryAssignmentId()
    {
        if (isset($this->assignment) == true) {
            foreach($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
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
        $chapter = Chapter::find( $this->getPrimaryAssignmentId() );
        if ( !empty( $chapter ) ) {
            return $chapter->chapter_name;
        } else {
            return false;
        }
    }

    public function getPrimaryBillet()
    {
        if (isset($this->assignment) == true) {
            foreach($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
                    return $assignment['billet'];
                }
            }
            return false;
        } else {
            return false;
        }
    }

    public function getPrimaryDateAssigned()
    {
        if (isset($this->assignment) == true) {
            foreach($this->assignment as $assignment) {
                if ($assignment['primary'] == true) {
                    return $assignment['date_assigned'];
                }
            }
            return false;
        } else {
            return false;
        }
    }
}
