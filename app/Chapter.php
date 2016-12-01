<?php

use Jenssegers\Mongodb\Model as Eloquent;

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
      'chapter_type' => 'required'
    ];

    static function getHoldingChapters()
    {
        $results =
          Chapter::where('joinable', '!=', false)
                 ->whereIn(
                     'hull_number',
                     ['SS-001', 'SS-002', 'RMOP-01', 'HC', 'RHSS-01', 'SMRS-01']
                 )
                 ->orderBy('chapter_name')
                 ->get();

        $chapters = [];

        foreach ($results as $chapter) {
            $chapters[$chapter->_id] = $chapter->chapter_name;
        }

        return $chapters;
    }

    static function getChaptersByType($type)
    {
        $results =
          Chapter::where('chapter_type', '=', $type)
                 ->orderBy('chapter_name')
                 ->get();

        $chapters = [];

        foreach ($results as $chapter) {
            switch ($type) {
                case 'SU':
                    $name =
                      $chapter->chapter_name . ' (' . $chapter->hull_number . ')';
                    break;
                case 'headquarters':
                    $name =
                      $chapter->chapter_name . ' (' . $chapter->branch . ')';
                    break;
                case 'fleet':
                    $fleet =
                      new NumberFormatter('en_US', NumberFormatter::ORDINAL);
                    $name =
                      $chapter->chapter_name . ' (' . $fleet->format($chapter->hull_number) . ')';
                    break;
                default:
                    $name = $chapter->chapter_name;
            }

            $chapters[$chapter->_id] = $name;
        }

        return $chapters;
    }

    static function getChapters(
        $branch = '',
        $location = 0,
        $joinableOnly = true
    ) {
        $nf = new NumberFormatter('en_US', NumberFormatter::ORDINAL);

        $holdingChapters =
          ['SS-001', 'SS-002', 'RMOP-01', 'HC', 'RHSS-01', 'SMRS-01'];

        if (empty($branch) === false) {
            $results =
              Chapter::where('branch', '=', strtoupper($branch))
                     ->where('joinable', '!=', false)
                     ->whereNull('decommission_date')
                     ->orderBy(
                         'chapter_name',
                         'asc'
                     )
                     ->get();
        } elseif ($joinableOnly === false) {
            $results =
              Chapter::orderBy('chapter_name', 'asc')
                     ->whereNull('decommission_date')
                     ->get();
        } else {
            $results =
              Chapter::where('joinable', '!=', false)
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
                $co = Chapter::find($chapter->_id)->getCO();

                if (empty($co) === true) {
                    $co = ['city' => null, 'state_province' => null];
                } else {
                    $co = $co->toArray();
                }

                $append = '';
                if (empty($co) === false && empty($co['city']) === false && empty($co['state_province']) == false) {
                    $append =
                      ' (' . $co['city'] . ', ' . $co['state_province'] . ')';
                }

                if ($chapter->chapter_type == 'fleet') {
                    $append =
                      ' (' . $nf->format($chapter->hull_number) . ' Fleet)';
                }

                if ($location == "0" || $co['state_province'] == $location) {
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
        $users =
          User::where('assignment.chapter_id', '=', (string)$this->_id)
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

        // Because of the way that mongo stores arrays, need to post process
        foreach ($users as $key => $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] == $this->id && in_array(
                    $assignment['billet'],
                    [
                      'Commanding Officer',
                      'Executive Officer',
                      'Bosun',
                      'Fleet Commander',
                      'Deputy Fleet Commander',
                      'Fleet Bosun',
                      'Space Lord',
                      'Deputy Space Lord',
                    ]
                ) === true
                ) {
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
                    if ($assignment['chapter_id'] == (string)$this->id) {
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
     * Get all users/members assigned to a specific chapter or subordinate chapters
     *
     * @param $id Optional Chapter ID.  If not present, the id of the current instantiation is used.
     *
     * @return mixed
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
     * Get all users/members assigned to a specific chapter, including the command crew
     *
     * @param $chapterId
     *
     * @return mixed
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

    public function getCommandBillet($billet, $exact = true)
    {
        $query =
          User::where('assignment.chapter_id', '=', $this->id)
              ->where('assignment.billet', '=', $billet);

        if ($exact === false) {
            $user = $query->first();

            return empty($user) === true ? [] : $user;
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

        return [];
    }

    public function getCO()
    {
        $users =
          User::where('assignment.chapter_id', '=', (string)$this->_id)
              ->whereIn(
                  'assignment.billet',
                  ['Commanding Officer', 'Fleet Commander', 'Space Lord']
              )
              ->get();

        if (empty($users) === true) {
            return [];
        }

        // Way too many edge cases

        foreach ($users as $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    ['Commanding Officer', 'Fleet Commander', 'Space Lord']
                )
                ) {
                    return $user;
                }
            }
        }

        return [];
    }

    public function getXO()
    {
        $users =
          User::where('assignment.chapter_id', '=', (string)$this->_id)
              ->whereIn(
                  'assignment.billet',
                  [
                  'Executive Officer',
                  'Deputy Fleet Commander',
                  'Deputy Space Lord'
                  ]
              )
              ->get();
        if (empty($users) === true) {
            return [];
        }

        foreach ($users as $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    [
                      'Executive Officer',
                      'Deputy Fleet Commander',
                      'Deputy Space Lord'
                    ]
                )
                ) {
                    return $user;
                }
            }
        }

        return [];
    }

    public function getBosun()
    {
        $users =
          User::where('assignment.chapter_id', '=', (string)$this->_id)
              ->whereIn(
                  'assignment.billet',
                  ['Bosun', 'Fleet Bosun', 'Gunny', 'NCOIC', 'Chief of Staff']
              )
              ->get();
        if (empty($users) === true) {
            return [];
        }

        foreach ($users as $user) {
            foreach ($user->assignment as $assignment) {
                if ($assignment['chapter_id'] === (string)$this->_id && in_array(
                    $assignment['billet'],
                    ['Bosun', 'Fleet Bosun', 'Gunny', 'NCOIC', 'Chief of Staff']
                )
                ) {
                    return $user;
                }
            }
        }

        return [];
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
        $replace = [\Medusa\Utility\MedusaUtility::ordinal($this->hull_number)];

        $billets = MedusaConfig::get('chapter.show', $default, $this->chapter_type);

        $commandCrew = [];

        foreach ($billets as $position => $billetInfo) {
            $position = str_replace($search, $replace, $position);
            $billetInfo['billet'] =
              str_replace($search, $replace, $billetInfo['billet']);

            $user =
              $this->getCommandBillet(
                  $billetInfo['billet'],
                  isset($billetInfo['exact']) === true ? $billetInfo['exact'] : true
              );
            if (is_a($user, 'User') === true) {
                $commandCrew[(int)$billetInfo['display_order']] = [
                  'display' => $position,
                  'user'    => $user,
                ];
            }
        }

        return $commandCrew;
    }

    public function getChapterIdWithParents($stopAtType = null)
    {
        if (empty($this->assigned_to) === false && is_null($stopAtType) === true) {
            return array_merge(
                [$this->id],
                Chapter::find($this->assigned_to)->getChapterIdWithParents($stopAtType)
            );
        } elseif (empty($this->assigned_to) === false && is_null($stopAtType) === false) {
            $next = Chapter::find($this->assigned_to);
            if ($next->chapter_type == $stopAtType) {
                return [$this->id];
            } else {
                return array_merge([$this->id], $next->getChapterIdWithParents($stopAtType));
            }
        } else {
            return [$this->id];
        }
    }

    public function getAssignedFleet()
    {
        foreach ($this->getChapterIdWithParents() as $chapterId) {
            $fleet = self::find($chapterId);
            if ($fleet->chapter_type == 'fleet') {
                $nf = new NumberFormatter('en_US', NumberFormatter::SPELLOUT);
                $nf->setTextAttribute(
                    NumberFormatter::DEFAULT_RULESET,
                    "%spellout-ordinal"
                );
                return ucfirst($nf->format($fleet->hull_number)) . ' Fleet';
            }
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

        return array_where(
            $this->getChapterIdWithChildren(),
            function ($key, $value) {
                if ($value != $this->id) {
                    return $value;
                }
            }
        );
    }

    /**
     * Get the chapter ID with all subordinate chapter IDs
     *
     * @param none
     *
     * @return mixed
     */

    public function getChapterIdWithChildren($id = null)
    {
        if (empty($id) === true) {
            $id = $this->id;
        }
        $children = Chapter::where('assigned_to', '=', $id)->get();

        $results = [];
        foreach ($children as $child) {
            $results =
              array_merge(
                  $results,
                  Chapter::find($child->id)->getChapterIdWithChildren()
              );
        }
        return array_unique(array_merge([$id], $results));
    }

    static function getChapterType($chapterId)
    {
        $chapter = Chapter::find($chapterId);
        return $chapter->chapter_type;
    }

    static function getChapterLocations()
    {
        $states = \Medusa\Enums\MedusaDefaults::STATES_BY_ABREVIATION;

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

    public function crewHasNewExams($id = null)
    {
        if (empty($id) === true) {
            $id = $this->id;
        }

        try {
            $crew = $this->getCrewWithChildren($id);
        } catch (Exception $d) {
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
