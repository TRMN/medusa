<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Moloquent implements UserInterface, RemindableInterface
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
     * Get the preferred rank title along with the rank title for the users permanent and brevet rank
     *
     * @param User $user
     * @return array
     */
    public function getRankTitles()
    {
        // Figure out the correct rank title to use for this user based on branch
        $branch = $this->branch;
        $rank = $this->rank[ 'permanent_rank' ][ 'grade' ];

        $gradeDetail = Grade::where( 'grade', '=', $rank )->get();

        $permRank = $gradeDetail[ 0 ]->rank[ $branch ];

        // Check for rating

        if ( isset( $this->rating ) === true && empty( $this->rating ) === false ) {
            if ( $rateGreeting = self::getRateTitle( $this->rating, $branch, $rank ) ) {
                $permRank = $rateGreeting;
            }
        }

        $greeting = $permRank;

        if ( isset( $this->rank[ 'brevet_rank' ] ) === true && empty( $this->rank[ 'brevet_rank' ] ) === false ) {
            $rank = $this->rank[ 'brevet_rank' ][ 'grade' ];

            $gradeDetail = Grade::where( 'grade', '=', $rank )->get();

            $brevetRank = $gradeDetail[ 0 ]->rank[ $branch ];

            // Check for rating

            if ( isset( $this->rating ) === true && empty( $this->rating ) === false ) {
                if ( $rateGreeting = self::getRateTitle( $this->rating, $branch, $rank ) ) {
                    $brevetRank = $rateGreeting;
                }
            }

            $greeting = $brevetRank;

        } else {
            $brevetRank = '';
        }

        return [ $greeting, $permRank, $brevetRank ];
    }

    /**
     * Return only the preferred rank title for a user
     *
     * @param User $user
     * @return mixed
     */
    public function getGreeting()
    {
        list( $greeting, $permRank, $brevetRank ) = self::getRankTitles();

        return $greeting;
    }

    /**
     * Get the rate specific rank title, if any
     *
     * @param $rating
     * @param $branch
     * @param $rank
     * @return mixed
     */
    static function getRateTitle( $rating, $branch, $rank )
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
     * @param User $user
     * @return array
     */
    static function getPrimaryAssignment( User $user )
    {
        if ( isset( $user->assignment ) ) {
            foreach ( $user->assignment as $assignment ) {
                if ( $assignment[ 'primary' ] === true ) {
                    $primary_assignment = $assignment[ 'chapter_id' ];
                    $primary_billet = $assignment[ 'billet' ];
                    $primary_date_assigned = $assignment[ 'date_assigned' ];
                }
            }
        } else {
            $primary_assignment = null;
            $primary_billet = null;
            $primary_date_assigned = null;
        }

        return [ $primary_assignment, $primary_billet, $primary_date_assigned ];
    }
}
