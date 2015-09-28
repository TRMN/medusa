<?php

use Jenssegers\Mongodb\Model as Eloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Chapter extends Eloquent
{

    protected $fillable = [
        'chapter_name',
        'chapter_type',
        'hull_number',
        'assigned_to',
        'ship_class',
        'commission_date',
        'decommission_date',
        'branch'
    ];

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
        $results = Chapter::where('joinable', '!=', false)->whereIn('hull_number', ['SS-001', 'SS-002', 'LP', 'HC'])
                          ->orderBy('chapter_name')->get();

        $chapters = [];

        foreach ($results as $chapter) {

            $chapters[$chapter->_id] = $chapter->chapter_name;
        }

        return $chapters;
    }

    static function getChaptersByType($type)
    {
        $results = Chapter::where('chapter_type', '=', $type)->orderBy('chapter_name')->get();

        $chapters = [];

        foreach ($results as $chapter) {

            switch ($type) {
                case 'SU':
                    $name = $chapter->chapter_name . ' (' . $chapter->hull_number . ')';
                    break;
                case 'headquarters':
                    $name = $chapter->chapter_name . ' (' . $chapter->branch . ')';
                    break;
                case 'fleet':
                    $fleet = new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                    $name = $chapter->chapter_name . ' (' . $fleet->format($chapter->hull_number) . ')';
                    break;
                default:
                    $name = $chapter->chapter_name;
            }

            $chapters[$chapter->_id] = $name;
        }

        return $chapters;
    }

    static function getChapters($branch = '', $location = 0, $joinableOnly = true)
    {
        $holdingChapters = ['SS-001', 'SS-002', 'LP', 'HC'];

        if (empty( $branch ) === false) {
            $results =
                Chapter::where('branch', '=', strtoupper($branch))->where('joinable', '!=', false)->orderBy(
                    'chapter_name',
                    'asc'
                )->get();
        } elseif ($joinableOnly === false) {
            $results = Chapter::orderBy('chapter_name', 'asc')->get();
        } else {
            $results = Chapter::where('joinable', '!=', false)->orderBy('chapter_name', 'asc')->get();
        }

        if (count($results) === 0) {
            //$results = Chapter::where('hull_number','=','SS-001')->get();
            return [];
        }

        $chapters = [];

        foreach ($results as $chapter) {
            if (isset( $chapter->hull_number ) === false) {
                $chapter->hull_number = null;
            }
            if (in_array($chapter->hull_number, $holdingChapters) === true) {
                continue;
            } else {
                $co = Chapter::find($chapter->_id)->getCO();

                if (empty( $co ) === true) {
                    $co = ['city' => null, 'state_province' => null];
                } else {
                    $co = $co->toArray();
                }

                $append = '';
                if (empty( $co ) === false && empty( $co['city'] ) === false && empty( $co['state_province'] ) == false) {
                    $append = ' (' . $co['city'] . ', ' . $co['state_province'] . ')';
                }

                if (is_numeric($location) === true || $co['state_province'] == $location) {
                    $chapters[$chapter->_id] = $chapter->chapter_name . $append;
                }
            }
        }

        asort($chapters, SORT_NATURAL);
        return $chapters;
    }

    /**
     * Get all users/members assigned to a specific chapter excluding the command crew
     *
     * @param $chapterId
     *
     * @return mixed
     */
    public function getCrew($forReport = false, $ts = null)
    {
        $users = User::where('assignment.chapter_id', '=', (string)$this->_id)->whereNotIn(
            'assignment.billet',
            [
                'Commanding Officer',
                'Executive Officer',
                'Bosun',
                'Fleet Commander',
                'Deputy Fleet Commander',
                'Fleet Bosun'
            ]
        )->where('active', '=', 1)->where('registration_status', '=', 'Active')->orderBy('last_name', 'asc')->orderBy(
            'rank.grade',
            'asc'
        )->get();

        if ($forReport === true) {

            $users = $users->toArray();
            // Only need members that have been assigned to the chapter since the last report

            foreach ($users as $key => $user) {
                foreach ($user['assignment'] as $assignment) {
                    $include = true;
                    if ($assignment['chapter_id'] == (string)$this->id) {
                        if (empty( $assignment['date_assigned'] ) === false && $assignment['date_assigned'] != '1969-01-01') {

                            if (strtotime($assignment['date_assigned']) < $ts) {
                                $include = false;
                            }
                        }
                    }

                    if ($include === false) {
                        unset( $users[$key] );
                    }
                }
            }
        }

        return $users;
    }
    /**
     * Get all users/members assigned to a specific chapter or subordinate chapters
     *
     * @param $chapterId
     *
     * @return mixed
     */

	public function getCrewWithChildren()
    {
        $users = User::wherein('assignment.chapter_id', $this->getChapterIdWithChildren())->where(	'member_id','!=',Auth::user()->member_id
        )->orderBy('last_name', 'asc')->get();

        return $users;
    }



    /**
     * Get all users/members assigned to a specific chapter, including the command crew
     *
     * @param $chapterId
     *
     * @return mixed
     */
    public function getAllCrew($chapterId)
    {
        return User::where('assignment.chapter_id', '=', $chapterId)->orderBy('last_name', 'asc')->get();
    }

    public function getCO()
    {
        $user =
            User::where('assignment.chapter_id', '=', (string)$this->_id)->whereIn(
                'assignment.billet',
                ['Commanding Officer', 'Fleet Commander']
            )->first();

        if (empty( $user ) === true) {
            return [];
        }

        // Sanity Check for strange edge cases

        $valid = false;

        foreach ($user->assignment as $assignment) {
            if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    ['Commanding Officer', 'Fleet Commander']
                )
            ) {
                $valid = true;
            }
        }

        if ($valid === false) {
            return [];
        }

        return $user;
    }

    public function getXO()
    {
        $user = User::where('assignment.chapter_id', '=', (string)$this->_id)->whereIn(
            'assignment.billet',
            ['Executive Officer', 'Deputy Fleet Commander']
        )->first();
        if (empty( $user ) === true) {
            return [];
        }

        // Sanity Check for strange edge cases

        $valid = false;

        foreach ($user->assignment as $assignment) {
            if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    ['Executive Officer', 'Deputy Fleet Commander']
                )
            ) {
                $valid = true;
            }
        }

        if ($valid === false) {
            return [];
        }

        return $user;
    }

    public function getBosun()
    {
        $user = User::where('assignment.chapter_id', '=', (string)$this->_id)->whereIn(
            'assignment.billet',
            ['Bosun', 'Fleet Bosun']
        )->first();
        if (empty( $user ) === true) {
            return [];
        }

        // Sanity Check for strange edge cases

        $valid = false;

        foreach ($user->assignment as $assignment) {
            if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    ['Bosun', 'Fleet Bosun']
                )
            ) {
                $valid = true;
            }
        }

        if ($valid === false) {
            return [];
        }

        return $user;
    }

    /**
     * Get the command crew for a chapter
     *
     * @param $chapterId
     *
     * @return mixed
     */
    public function getCommandCrew()
    {
        $users['CO'] = $this->getCO();
        $users['XO'] = $this->getXO();
        $users['BOSUN'] = $this->getBosun();

        foreach (['CO', 'XO', 'BOSUN'] as $command) {
            if (empty( $users[$command] ) === true) {
                unset( $users[$command] );
            }
        }

        return $users;
    }

    public function getChapterIdWithParents()
    {
        if (empty( $this->assigned_to ) === false) {
            return array_merge([$this->id], Chapter::find($this->assigned_to)->getChapterIdWithParents());
        } else {
            return [$this->id];
        }
    }

      /**
     * Get the chapter IDs of all subordinate chapters, but strip this one
     *
     * @param none
     *
     * @return mixed
     */
    public function getChildChapters()
    {


        return array_where($this->getChapterIdWithChildren(), function($key, $value) { if ($value != $this->id) return $value;});

    }

    /**
     * Get the chapter ID with all subordinate chapter IDs
     *
     * @param none
     *
     * @return mixed
     */

    public function getChapterIdWithChildren()
    {
        $children = Chapter::where('assigned_to', '=', (string)$this->_id)->get();

        $results = [];
        foreach($children as $child) {
            $results = array_merge($results, Chapter::find($child->id)->getChapterIdWithChildren());
        }
        return array_unique(array_merge([$this->id], $results));
    }

    static function getChapterType($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        return $chapter->chapter_type;
    }

    static function getChapterLocations()
    {
        $states = \Medusa\Enums\MedusaDefaults::STATES_BY_ABREVIATION;

        $results = User::where('assignment.billet', '=', 'Commanding Officer')->get(['state_province', 'assignment']);

        $chapterLocations = [];

        foreach ($results as $location) {
            $chapterLocations[$location->state_province] = true;
        }

        ksort($chapterLocations);

        $retVal = [];

        foreach (array_keys($chapterLocations) as $location) {
            $retVal[$location] = array_key_exists($location, $states) === true ? $states[$location] : $location;
        }

        return $retVal;
    }

}
