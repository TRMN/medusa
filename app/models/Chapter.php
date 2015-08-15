<?php

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Chapter extends Eloquent
{

    protected $fillable = [ 'chapter_name', 'chapter_type', 'hull_number', 'assigned_to', 'ship_class', 'commission_date', 'decommission_date' ];

    public static $rules = [
        'chapter_name' => 'required|min:6|unique:chapters',
        'chapter_type' => 'required',
    ];

    public static $updateRules = [
        'chapter_name' => 'required|min:6',
        'chapter_type' => 'required'
    ];


    static function getHoldingChapters()
    {
        $results = Chapter::where('joinable', '!=', false)->whereIn('hull_number', ['SS-001', 'SS-002', 'LP', 'HC'])->get();

        $chapters = [];

        foreach ($results as $chapter) {

            $chapters[$chapter->_id] = $chapter->chapter_name;
        }

        return $chapters;
    }
    static function getChapters($branch = '', $location = 0)
    {
        $holdingChapters = [ 'SS-001', 'SS-002', 'LP', 'HC' ];

        if (empty($branch) === false) {
            $results = Chapter::where('branch', '=', strtoupper($branch))->where('joinable', '!=', false)->orderBy('chapter_name','asc')->get();
        } else {
            $results = Chapter::where('joinable', '!=', false)->orderBy('chapter_name', 'asc')->get();
        }

        if (count($results) === 0) {
            //$results = Chapter::where('hull_number','=','SS-001')->get();
            return [];
        }

        $chapters = [ ];

        foreach ( $results as $chapter ) {
            if ( isset( $chapter->hull_number ) === true && empty( $chapter->hull_number ) === false ) {
                if ( in_array( $chapter->hull_number, $holdingChapters ) === true ) {
                    continue;
                } else {
                    $co = Chapter::find($chapter->_id)->getCO();

                    if (empty($co[0]) === true) {
                        $co = ['city' => null, 'state_province' => null];
                    } else {
                        $co = $co[0]->toArray();
                    }

                    $append = '';
                    if (empty($co) === false && empty($co['city']) === false && empty($co['state_province']) == false) {
                        $append = ' (' . $co['city'] . ', ' . $co['state_province'] . ')';
                    }

                    if (is_numeric($location) === true || $co['state_province'] == $location) {
                        $chapters[$chapter->_id] = $chapter->chapter_name . $append;
                    }
                }
            }
        }

        asort( $chapters, SORT_NATURAL );

        //$chapters = [ '' => "Select a Chapter" ] + $chapters;

        return $chapters;
    }

    /**
     * Get all users/members assigned to a specific chapter excluding the command crew
     *
     * @param $chapterId
     * @return mixed
     */
    public function getCrew() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->whereNotIn( 'assignment.billet', [ 'Commanding Officer', 'Executive Officer', 'Bosun' ])->orderBy('last_name', 'asc')->get();

        return $users;
    }

    /**
     * Get all users/members assigned to a specific chapter, including the command crew
     *
     * @param $chapterId
     * @return mixed
     */
    public function getAllCrew( $chapterId )
    {
        return User::where( 'assignment.chapter_id', '=', $chapterId )->orderBy('last_name', 'asc')->get();
    }

    public function getCO() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'Commanding Officer' )->get();
        if (isset($users[0]) === false) {
            return [];
        }
        return $users;
    }

    public function getXO() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'Executive Officer' )->get();
        if (isset( $users[0]) === false) {
            return [];
        }
        return $users;
    }

    public function getBosun() {
        $users = User::where( 'assignment.chapter_id', '=', (string)$this->_id )->where( 'assignment.billet', '=', 'Bosun' )->get();
        if (isset( $users[0]) === false) {
            return [];
        }
        return $users;
    }

    /**
     * Get the command crew for a chapter
     *
     * @param $chapterId
     * @return mixed
     */
    public function getCommandCrew() {
        $users['CO'] = $this->getCO();
        $users['XO'] = $this->getXO();
        $users['BOSUN'] = $this->getBosun();

        foreach(['CO','XO','BOSUN'] as $command) {
            if (empty($users[$command]) === true) {
                unset($users[$command]);
            }
        }

        return $users;
    }

    static function getChapterType($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        return $chapter->chapter_type;
    }

    static function getChapterLocations()
    {
        $states = \Medusa\Enums\MedusaDefaults::STATES_BY_ABREVIATION;

        $results = User::where('assignment.billet', '=', 'Commanding Officer')->get(['state_province','assignment']);

        $chapterLocations = [];

        foreach ($results as $location) {
            $chapterLocations[$location->state_province] = true;
        }

        ksort($chapterLocations);

        $retVal = [];

        foreach(array_keys($chapterLocations) as $location) {
            $retVal[$location] = array_key_exists($location, $states) === true?$states[$location]:$location;
        }

        return $retVal;
    }

}
