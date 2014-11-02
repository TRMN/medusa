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
     * Get the command crew for a chapter
     *
     * @param $chapterId
     * @return mixed
     */
    static function getCommandCrew( $chapterId )
    {
        return User::where( 'assignment.chapter_id', '=', $chapterId )->whereIn( 'assignment.billet', [ 'CO', 'XO', 'Bosun' ] )->get();

    }

    /**
     * Get all users/members assigned to a specific chapter excluding the command crew
     *
     * @param $chapterId
     * @return mixed
     */
    static function getCrew( $chapterId )
    {
        return User::where( 'assignment.chapter_id', '=', $chapterId )->whereNotIn( 'assignment.billet', [ 'CO', 'XO', 'Bosun' ] )->get();
    }

    /**
     * Get all users/members assigned to a specific chapter, including the command crew
     *
     * @param $chapterId
     * @return mixed
     */
    static function getAllCrew( $chapterId )
    {
        return User::where( 'assignment.chapter_id', '=', $chapterId )->get();
    }

    /**
     * Return only the preferred rank title for a user
     *
     * @return mixed
     */
    public function getGreeting() {

        $this->getDisplayRank();
        $brevert = false;

        $rank = $this->perm_display;

        if( isset( $this->brevet_rank ) && !empty( $this->brevet_rank ) ) {
            $rank = $this->brevet_display;
            $brevert = true;
        }

        $greeting[ 'rank' ] = $rank;

        if ( isset( $this->rating ) && !empty( $this->rating ) && !$brevert ) {
            if ( $rateGreeting = $this->getRateTitle( $this->rating, $this->branch, $rank ) ) {
                $greeting[ 'rank' ] = $rateGreeting;
            }
        }

        // Here for now, but $authUser->last_name will probably do
        $greeting[ 'last_name' ] = $this->last_name;

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
     * @param $rating
     * @param $branch
     * @param $rank
     * @return mixed
     */
    function getRateTitle( $rating, $branch, $rank )
    {
        $rateDetail = Rating::where( 'rate_code', '=', $rating )->get();

        if ( isset( $rateDetail[ 0 ]->rate[ $branch ][ $rank ] ) === true && empty( $rateDetail[ 0 ]->rate[ $branch ][ $rank ] ) === false ) {
            return $rateDetail[ 0 ]->rate[ $branch ][ $rank ];
        }

        return false;
    }

    /**
     * Get a users primary assignment
     *
     * @return array
     */
    function getPrimaryAssignment()
    {
        $primary_assignment = null;
        $primary_billet = null;
        $primary_date_assigned = null;

        if ( isset( $this->assignment ) ) {
            foreach ( $this->assignment as $assignment ) {
                if ( $assignment[ 'primary' ] === true ) {
                    $primary_assignment = $assignment[ 'chapter_id' ];
                    $primary_billet = $assignment[ 'billet' ];
                    $primary_date_assigned = $assignment[ 'date_assigned' ];
                }
            }
        }

        return [ $primary_assignment, $primary_billet, $primary_date_assigned ];
    }
}
