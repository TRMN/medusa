<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use NumberFormatter;

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
        'branch',
        'joinable',
        'idcards_printed',
    ];

    public static $rules = [
        'chapter_name' => 'required|min:6|unique:chapters',
        'chapter_type' => 'required',
    ];

    public static $updateRules = [
        'chapter_name' => 'required|min:6',
        'chapter_type' => 'required',
    ];

    /**
     * Get a list of holding chapters.
     *
     * @return array
     */
    public static function getHoldingChapters()
    {
        $results =
            self::where('joinable', '!=', false)
                ->whereIn(
                    'hull_number',
                    MedusaConfig::get('chapter.holding')
                )
                ->orderBy('chapter_name')
                ->get();

        $chapters = [];

        foreach ($results as $chapter) {
            $chapters[$chapter->_id] = $chapter->chapter_name;
        }

        return $chapters;
    }

    /**
     * Get a list of chapters by type.
     *
     * @param $type
     *
     * @return array
     */
    public static function getChaptersByType($type)
    {
        $results =
            self::where('chapter_type', '=', $type)
                ->orderBy('chapter_name')
                ->get();

        $chapters = [];

        foreach ($results as $chapter) {
            switch ($type) {
                case 'SU':
                    $name =
                        $chapter->chapter_name.' ('.$chapter->hull_number.')';
                    break;
                case 'headquarters':
                    $name =
                        $chapter->chapter_name.' ('.$chapter->branch.')';
                    break;
                case 'fleet':
                    $fleet =
                        new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                    $name =
                        $chapter->chapter_name.' ('.$fleet->format($chapter->hull_number).')';
                    break;
                default:
                    $name = $chapter->chapter_name;
            }

            $chapters[$chapter->_id] = $name;
        }

        return $chapters;
    }

    /**
     * Get all chapters with an option to skip unjoinable chapters.
     *
     * @param bool $showUnjoinable
     *
     * @return array
     */
    public static function getFullChapterList($showUnjoinable = true)
    {
        $chapters = [];

        foreach (MedusaConfig::get('chapter.selection') as $item) {
            if ($item['unjoinable'] === $showUnjoinable || $item['unjoinable'] === false) {
                if (isset($item['args']) === true) {
                    $chapters[$item['label']] = call_user_func($item['call'], $item['args']);
                } else {
                    $chapters[$item['label']] = call_user_func($item['call']);
                }
            }
        }

        return $chapters;
    }

    /**
     * Get chapters filtered by branch and location.
     *
     * @param string $branch
     * @param int $location
     * @param bool $joinableOnly
     *
     * @return array
     */
    public static function getChapters($branch = '', $location = 0, $joinableOnly = true)
    {
        $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);

        $holdingChapters =
            MedusaConfig::get('chapter.holding');

        if (empty($branch) === false) {
            $results =
                self::where('branch', '=', strtoupper($branch))
                    ->where('joinable', '!=', false)
                    ->whereNull('decommission_date')
                    ->orderBy(
                        'chapter_name',
                        'asc'
                    )
                    ->get();
        } elseif ($joinableOnly === false) {
            $results =
                self::orderBy('chapter_name', 'asc')
                    ->whereNull('decommission_date')
                    ->get();
        } else {
            $results =
                self::where('joinable', '!=', false)
                    ->whereNull('decommission_date')
                    ->orderBy('chapter_name', 'asc')
                    ->get();
        }

        if (count($results) === 0) {
            return [];
        }

        $chapters = [];

        foreach ($results as $chapter) {
            if (isset($chapter->hull_number) === false) {
                $chapter->hull_number = null;
            }
            if (in_array($chapter->hull_number, $holdingChapters) === true) {
                if ($joinableOnly === false) {
                    $chapters[$chapter->_id] = $chapter->chapter_name;
                } else {
                    continue;
                }
            } else {
                $co = self::find($chapter->_id)->getCO();

                if (empty($co) === true) {
                    $co = ['city' => null, 'state_province' => null];
                } else {
                    $co = $co->toArray();
                }

                $append = '';
                if (empty($co) === false && empty($co['city']) === false && empty($co['state_province']) == false) {
                    $append =
                        ' ('.$co['city'].', '.$co['state_province'].')';
                }

                if ($chapter->chapter_type == 'fleet') {
                    $append =
                        ' ('.$nf->format($chapter->hull_number).' Fleet)';
                }

                if ($location == '0' || $co['state_province'] == $location) {
                    $chapters[$chapter->_id] = $chapter->chapter_name.$append;
                }
            }
        }

        asort($chapters, SORT_NATURAL);

        return $chapters;
    }

    /**
     * Get the name of chapter given an id.
     *
     * @param $chapterId
     *
     * @return mixed
     */
    public static function getName($chapterId)
    {
        return self::find($chapterId)->chapter_name;
    }

    /**
     * Get the id of a chapter by the chapters name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public static function getIdByName(string $name)
    {
        return self::where('chapter_name', $name)->first()->_id;
    }

    /**
     * Get all users/members assigned to a specific chapter excluding the command crew.
     *
     * @TODO Refactor this
     *
     * @return mixed
     */
    public function getCrew($forReport = false, $ts = null)
    {
        $users =
            User::where('assignment.chapter_id', '=', (string) $this->_id)
                ->where('active', '=', 1)
                ->where(
                    'registration_status',
                    '=',
                    'Active'
                )
                ->orderBy('last_name', 'asc')
                ->orderBy(
                    'rank.grade',
                    'asc'
                )
                ->get();

        $commandBillets = [
            'Commanding Officer',
            'Executive Officer',
            'Bosun',
            'Fleet Commander',
            'Deputy Fleet Commander',
            'Fleet Bosun',
            'Space Lord',
            'Deputy Space Lord',
        ];

        // Because of the way that mongo stores arrays, need to post process
        foreach ($users as $key => $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] == $this->id && in_array($assignment['billet'], $commandBillets) === true) {
                    unset($users[$key]);
                }
            }
        }

        if ($forReport === true) {
            $users = $users->toArray();
            // Only need members that have been assigned to the chapter since the last report

            foreach ($users as $key => $user) {
                foreach ($user['assignment'] as $assignment) {
                    $include = true;
                    if ($assignment['chapter_id'] == (string) $this->id) {
                        if (empty($assignment['date_assigned']) === false && $assignment['date_assigned'] != '1969-01-01') {
                            if (strtotime($assignment['date_assigned']) < $ts) {
                                $include = false;
                            }
                        }
                    }

                    if ($include === false) {
                        unset($users[$key]);
                    }
                }
            }
        }

        return $users;
    }

    /**
     * Get all users/members assigned to a specific chapter or subordinate chapters.
     *
     * @param $id Optional Chapter ID.  If not present, the id of the current instantiation is used.
     *
     * @return User[]
     */
    public function getCrewWithChildren($id = null)
    {
        if (empty($id) === true) {
            $id = $this->id;
        }
        $users =
            User::wherein(
                'assignment.chapter_id',
                $this->getChapterIdWithChildren($id)
            )->where(
                'member_id',
                '!=',
                Auth::user()->member_id
            )->orderBy('last_name', 'asc')->get();

        return $users;
    }

    /**
     * Get all users/members assigned to a specific chapter, including the command crew.
     *
     * @param $chapterId
     *
     * @return User[]
     */
    public function getAllCrew($chapterId = null)
    {
        if (empty($chapterId) === true) {
            $chapterId = $this->id;
        }

        return User::where('assignment.chapter_id', '=', $chapterId)
            ->where('active', '=', 1)
            ->where(
                'registration_status',
                '=',
                'Active'
            )
            ->orderBy('last_name', 'asc')
            ->get();
    }

    public function getActiveCrewCount($chapterId = null)
    {
        return count($this->getAllCrew($chapterId));
    }

    /**
     * @param string|null $chapterId
     *
     * @return User[]
     */
    public function getAllCrewIncludingChildren(string $chapterId = null)
    {
        if (empty($chapterId) === true) {
            $chapterId = $this->id;
        }

        $chapters = $this->getChapterIdWithChildren($chapterId);

        return User::whereIn('assignment.chapter_id', $chapters)
            ->where('active', '=', 1)
            ->where(
                'registration_status',
                '=',
                'Active'
            )
            ->orderBy('last_name', 'asc')
            ->get();
    }

    /**
     * Return the user that is filling that specified billet for this chapter.  Peerage land aware.
     *
     * @param $billet
     * @param bool $exact
     * @param bool $allow_courtesy
     *
     * @return User
     */
    public function getCommandBillet($billet, $exact = true, $allow_courtesy = true)
    {
        $query =
            User::where('assignment.chapter_id', '=', $this->id)
                ->where('assignment.billet', '=', $billet);

        if ($exact === false) {
            $user = $query->first();

            return empty($user) === true ? $this->findPeerByLand($billet, $allow_courtesy) : $user;
        }

        $users = $query->get();

        if (empty($users) === true) {
            return [];
        }

        // Deal with edge cases
        foreach ($users as $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] === $this->id &&
                    $assignment['billet'] == $billet
                ) {
                    return $user;
                }
            }
        }

        return $this->findPeerByLand($billet, $allow_courtesy);
    }

    /**
     * @param $title
     * @param $allow_courtesy
     *
     * @return User
     */
    public function findPeerByLand($title, $allow_courtesy)
    {
        if (in_array($this->chapter_type, ['barony', 'county', 'steading', 'duchy', 'grand_duchy']) === true) {
            $query = User::where(
                'peerages.lands',
                str_replace(' Steading', '', $this->chapter_name)
            )->where('peerages.title', $title);

            if ($allow_courtesy === false) {
                $query = $query->where('peerages.courtesy', '!=', true);
            } else {
                $query = $query->where('peerages.courtesy', true);
            }

            return $query->first();
        } elseif ($this->chapter_type == 'keep') {
            // Keeps don't have land, we need to do a slightly different query
            return User::where('peerages.postnominal', 'KSK')->where('peerages.title', $title)->where(
                'last_name',
                str_replace(' Keep', '', $this->chapter_name)
            )->first();
        }

        return [];
    }

    /**
     * Get the CO or equiv of a chapter.
     *
     * @return User|array
     */
    public function getCO()
    {
        return $this->_getTriadMember(1);
    }

    /**
     * Get the XO or equiv of a chapter.
     *
     * @return User|array
     */
    public function getXO()
    {
        return $this->_getTriadMember(2);
    }

    /**
     * Get the Bosun or equiv of a chapter.
     *
     * @return User|array
     */
    public function getBosun()
    {
        return $this->_getTriadMember(3);
    }

    /**
     * Return user returned for a specific slot in the command triad results.
     *
     * @TODO Refactor to return null instead of an empty array.  Will have to check all code that calls this.
     *
     * @param $slot
     *
     * @return User|array
     */
    private function _getTriadMember($slot)
    {
        $triad = $this->getCommandCrew();

        if (empty($triad[$slot]) === false) {
            return $triad[$slot]['user'];
        }
    }

    /**
     * Get the command crew for a chapter.
     *
     * @param $chapterId
     *
     * @return array
     */
    public function getCommandCrew()
    {
        $default = json_decode('{
            "Commanding Officer": {
                "billet": "Commanding Officer",
                "display_order": 1
            },
            "Executive Officer": {
                "billet": "Executive Officer",
                "display_order": 2
            },
            "Bosun": {
                "billet": "Bosun",
                "display_order": 3
            }
        }', true);

        $search = ['%ordinal%'];
        $replace = [\App\Utility\MedusaUtility::ordinal($this->hull_number)];

        $billets = MedusaConfig::get('chapter.show', $default, $this->chapter_type);

        $commandCrew = [];

        foreach ($billets as $position => $billetInfo) {
            $display = $position = str_replace($search, $replace, $position);
            if (isset($billetInfo['billet']) === true) {
                $billetInfo['billet'] =
                    str_replace($search, $replace, $billetInfo['billet']);
            }

            if (strpos($position, '|') > 0) {
                // Currently used for peerage lands, as there are two possible billets for the top two slots, but
                // A courtesy title can't hold the first slot

                foreach (explode('|', $position) as $display) {
                    $user = $this->getCommandBillet(
                        $display,
                        isset($billetInfo['exact']) === true ? $billetInfo['exact'] : true,
                        isset($billetInfo['allow_courtesy']) === true ? $billetInfo['allow_courtesy'] : true
                    );

                    if (is_a($user, \App\User::class) === true) {
                        break 1;
                    }
                }
            } else {
                $user =
                    $this->getCommandBillet(
                        $billetInfo['billet'],
                        isset($billetInfo['exact']) === true ? $billetInfo['exact'] : true,
                        isset($billetInfo['allow_courtesy']) === true ? $billetInfo['allow_courtesy'] : true
                    );
            }

            if (is_a($user, \App\User::class) === true) {
                $commandCrew[(int) $billetInfo['display_order']] = [
                    'display' => $display,
                    'user' => $user,
                ];
            }
        }

        return $commandCrew;
    }

    /**
     * Get a list of Chapter ID's and parents, with an option to stop at a certain type of chapters.
     *
     * @param string $stopAtType
     *
     * @return array
     */
    public function getChapterIdWithParents($stopAtType = null)
    {
        if (empty($this->assigned_to) === false && is_null($stopAtType) === true) {
            return array_merge(
                [$this->id],
                self::find($this->assigned_to)->getChapterIdWithParents($stopAtType)
            );
        } elseif (empty($this->assigned_to) === false && is_null($stopAtType) === false) {
            $next = self::find($this->assigned_to);
            if ($next->chapter_type == $stopAtType) {
                return [$this->id];
            } else {
                return array_merge([$this->id], $next->getChapterIdWithParents($stopAtType));
            }
        } else {
            return [$this->id];
        }
    }

    /**
     * Get the fleet a ship is assigned to.
     *
     * @return string|null
     */
    public function getAssignedFleet($idOnly = false)
    {
        foreach ($this->getChapterIdWithParents() as $chapterId) {
            $fleet = self::find($chapterId);
            if ($fleet->chapter_type == 'fleet') {
                if ($idOnly === true) {
                    return $fleet->id;
                }
                $nf = new NumberFormatter('en_US', NumberFormatter::SPELLOUT);
                $nf->setTextAttribute(
                    NumberFormatter::DEFAULT_RULESET,
                    '%spellout-ordinal'
                );

                return ucfirst($nf->format($fleet->hull_number)).' Fleet';
            }
        }
    }

    /**
     * Get the chapter IDs of all subordinate chapters, but strip this one.
     *
     * @param none
     *
     * @return array
     */
    public function getChildChapters()
    {
        return Arr::where(
            $this->getChapterIdWithChildren(),
            function ($value, $key) {
                if ($value != $this->id) {
                    return $value;
                }
            }
        );
    }

    /**
     * Get the chapter ID with all subordinate chapter IDs.
     *
     * @param string $id
     *
     * @return array
     */
    public function getChapterIdWithChildren(string $id = null)
    {
        if (empty($id) === true) {
            $id = $this->id;
        }
        $children = self::where('assigned_to', '=', $id)->whereNull('decommission_date')->get();

        $results = [];
        foreach ($children as $child) {
            $results =
                array_merge(
                    $results,
                    self::find($child->id)->getChapterIdWithChildren()
                );
        }

        return array_unique(array_merge([$id], $results));
    }

  /**
   * Get the number of active child chapters for the given chapter
   *
   * @param string $id
   *
   * @return mixed
   */
    public function getNumActiveChildren(string $id = null) {
      if (empty($id) === true) {
        $id = $this->id;
      }

      return self::where('assigned_to', '=', $id)->whereNull('decommission_date')->count();
    }

    /**
     * Generate a hierarchical tree of a chapter's children.
     *
     * @return array
     */
    public function getChildHierarchy()
    {
        $children = self::where('assigned_to', '=', $this->id)->whereNull('decommission_date')->get();

        $results = [];

        foreach ($children as $child) {
            $c = self::where('assigned_to', $child->id)->whereNull('decommission_date')->get();
            if (count($c) > 0) {
                $results[] = ['chapter' => $child, 'children' => $child->getChildHierarchy()];
            } else {
                $results[] = ['chapter' => $child, 'children' => []];
            }
        }

        return $results;
    }

    /**
     * Get the Chapter Type.
     *
     * @param string $chapterId
     *
     * @return mixed
     */
    public static function getChapterType(string $chapterId)
    {
        $chapter = self::find($chapterId);

        return $chapter->chapter_type;
    }

    /**
     * Get a list of all chapter locations.
     *
     * @return array
     * @deprecated
     */
    public static function getChapterLocations()
    {
        $states = \App\Enums\MedusaDefaults::STATES_BY_ABREVIATION;

        $results =
            User::where('assignment.billet', '=', 'Commanding Officer')
                ->get(['state_province', 'assignment']);

        $chapterLocations = [];

        foreach ($results as $location) {
            $chapterLocations[$location->state_province] = true;
        }

        ksort($chapterLocations);

        $retVal = [];

        foreach (array_keys($chapterLocations) as $location) {
            $retVal[$location] =
                array_key_exists(
                    $location,
                    $states
                ) === true ? $states[$location] : $location;
        }

        return $retVal;
    }

    /**
     * Are there any new exams for this crew?
     *
     * @param string|null $id
     *
     * @return bool
     */
    public function crewHasNewExams(string $id = null)
    {
        if (empty($id) === true) {
            $id = $this->id;
        }

        try {
            $crew = $this->getCrewWithChildren($id);
        } catch (\Exception $d) {
            return false;
        }

        $hasExams = false;

        foreach ($crew as $member) {
            if ($member->hasNewExams() === true) {
                $hasExams = true;
            }
        }

        return $hasExams;
    }
}
