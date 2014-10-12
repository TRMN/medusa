<?php

class UserController extends \BaseController
{

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();

        return View::make( 'user.index', [ 'users' => $users ] );
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create()
    {
        return View::make( 'user.create', [ 'user' => new User ] );
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {

        $validator = Validator::make( $data = Input::all(), User::$rules, User::$error_message );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        // Massage the data a little bit.  First, build up the rank array

        $rank = [];

        if (isset($data['permanent_rank']) === true && empty($data['permanent_rank']) === false) {
            $rank['permanent_rank'] = ['grade' => $data['permanent_rank'], 'date_of_rank' => date('Y-m-d', strtotime($data['perm_dor']))];
            unset($data['permanent_rank'], $data['perm_dor']);
        }

        if (isset($data['brevet_rank']) === true && empty($data['brevet_rank']) === false) {
            $rank['brevet_rank'] = ['grade' => $data['brevet_rank'], 'date_of_rank' => date('Y-m-d', strtotime($data['brevet_dor']))];
            unset($data['brevet_rank'], $data['brevet_dor']);
        }

        $data['rank'] = $rank;

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id' => $data['primary_assignment'],
            'chapter_name' => $chapterName,
            'date_assigned' => date('Y-m-d', strtotime($data['primary_date_assigned'])),
            'billet' => $data['primary_billet'],
            'primary' => true
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true && empty($data['secondary_assignment']) === false) {
            $chapterName = Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['secondary_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date('Y-m-d', strtotime($data['secondary_date_assigned'])),
                'billet' => $data['secondary_billet'],
                'primary' => false
            ];

            unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);
        }

        $data['assignment'] = $assignment;

        // For future use

        $data['peerage_record'] = [];

        $data['awards_record'] = [];

        $data['exam_record'] = [];

        unset($data['_token']);

        User::create( $data );

        return Redirect::route( 'user.index' );
    }

    /**
     * Display the specified user.
     *
     * @param  User $user
     * @return Response
     */
    public function show( User $user )
    {

        list($greeting, $permRank, $brevetRank) = $this->_getRankTitle($user);

        if (isset($user->rating) === true && empty($user->rating) === false) {
            $user->rating = ['rate' => $user->rating, 'description' => Rating::where('rate_code', '=', $user->rating)->get()[0]->rate['description']];
        }

        return View::make( 'user.show', [
            'user' => $user,
            'greeting' => $greeting,
            'countries' => $this->_getCountries(),
            'branches' => Branch::getBranchList(),
            'permRank' => $permRank,
            'brevetRank' => $brevetRank] );
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User $user
     * @return Response
     */
    public function edit( User $user )
    {
        list($greeting, $permRank, $brevetRank) = $this->_getRankTitle($user);

        if (isset($user->rating) === true && empty($user->rating) === false) {
            $user->rating = ['rate' => $user->rating, 'description' => Rating::where('rate_code', '=', $user->rating)->get()[0]->rate['description']];
        }

        $user->permanent_rank = $user->rank['permanent_rank']['grade'];
        
        $user->perm_dor = $user->rank['permanent_rank']['date_of_rank'];

        if (empty($user->brevet_rank) === false) {
            $user->brevet_rank = $user->rank['brevet_rank']['grade'];
            $user->brevet_dor = $user->rank['brevet_rank']['date_of_rank'];
        }

        foreach ($user->assignment as $assignment) {
            if ($assignment['primary'] === true) {
                $user->primary_assignment = $assignment['chapter_id'];
                $user->primary_billet = $assignment['billet'];
                $user->primary_date_assigned = $assignment['date_assigned'];
            }

        }

        return View::make( 'user.edit', [
            'user' => $user,
            'greeting' => $greeting,
            'countries' => $this->_getCountries(),
            'branches' => Branch::getBranchList(),
            'grades' => Grade::getGradesForBranch($user->branch),
            'ratings' => Rating::getRatingsForBranch($user->branch),
            'chapters' => Chapter::getChapters(),
            'permRank' => $permRank,
            'brevetRank' => $brevetRank] );
    }

    /**
     * Update the specified user in storage.
     *
     * @param  User $user
     * @return Response
     */
    public function update( User $user )
    {
        $validator = Validator::make( $data = Input::all(), User::$updateRules, User::$error_message );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

        // Massage the data a little bit.  First, build up the rank array

        $rank = [];

        if (isset($data['permanent_rank']) === true && empty($data['permanent_rank']) === false) {
            $rank['permanent_rank'] = ['grade' => $data['permanent_rank'], 'date_of_rank' => date('Y-m-d', strtotime($data['perm_dor']))];
            unset($data['permanent_rank'], $data['perm_dor']);
        }

        if (isset($data['brevet_rank']) === true && empty($data['brevet_rank']) === false) {
            $rank['brevet_rank'] = ['grade' => $data['brevet_rank'], 'date_of_rank' => date('Y-m-d', strtotime($data['brevet_dor']))];
            unset($data['brevet_rank'], $data['brevet_dor']);
        }

        $data['rank'] = $rank;

        // Build up the member assignments

        $chapterName = Chapter::find($data['primary_assignment'])->chapter_name;

        $assignment[] = [
            'chapter_id' => $data['primary_assignment'],
            'chapter_name' => $chapterName,
            'date_assigned' => date('Y-m-d', strtotime($data['primary_date_assigned'])),
            'billet' => $data['primary_billet'],
            'primary' => true
        ];

        unset($data['primary_assignment'], $data['primary_date_assigned'], $data['primary_billet']);

        if (isset($data['secondary_assignment']) === true && empty($data['secondary_assignment']) === false) {
            $chapterName = Chapter::find($data['secondary_assignment'])->chapter_name;

            $assignment[] = [
                'chapter_id' => $data['secondary_assignment'],
                'chapter_name' => $chapterName,
                'date_assigned' => date('Y-m-d', strtotime($data['secondary_date_assigned'])),
                'billet' => $data['secondary_billet'],
                'primary' => false
            ];

            unset($data['secondary_assignment'], $data['secondary_date_assigned'], $data['secondary_billet']);
        }

        $data['assignment'] = $assignment;

        // For future use

        $data['peerage_record'] = [];

        $data['awards_record'] = [];

        $data['exam_record'] = [];

        unset( $data[ '_method' ], $data[ '_token' ] );

        $user->update( $data );

        return Redirect::route( 'user.index' );
    }

    /**
     * Confirm that the user should be deleted.
     *
     * @param  User $user
     * @return Response
     */
    public function confirmDelete( User $user )
    {
        return View::make( 'user.confirm-delete', [ 'user' => $user ] );
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy( User $user )
    {
        User::destroy( $user->_id );

        return Redirect::route( 'user.index' );
    }

    private function _getCountries()
    {
        $results = Countries::getList();
        $countries = array();

        foreach($results as $country) {
            $countries[$country['iso_3166_3']] = $country['name'];
        }

        return $countries;
    }

    private function _getRankTitle(User $user)
    {
        // Figure out the correct rank title to use for this user based on branch
        $branch = $user->branch;
        $rank = $user->rank['permanent_rank']['grade'];

        $gradeDetail = Grade::where('grade', '=', $rank)->get();

        $permRank = $gradeDetail[0]->rank[$branch];

        // Check for rating

        if (isset($user->rating) === true && empty($user->rating) === false) {
            if ($rateGreeting = $this->_getRateTitle(['rating' => $user->rating, 'branch' => $branch, 'rank' => $rank])) {
                $permRank = $rateGreeting;
            }
        }

        $greeting = $permRank;

        if (isset($user->rank['brevet_rank']) === true && empty($user->rank['brevet_rank']) === false) {
            $rank = $user->rank['brevet_rank']['grade'];

            $gradeDetail = Grade::where('grade', '=', $rank)->get();

            $brevetRank = $gradeDetail[0]->rank[$branch];

            // Check for rating

            if (isset($user->rating) === true && empty($user->rating) === false) {
                if ($rateGreeting = $this->_getRateTitle(['rating' => $user->rating, 'branch' => $branch, 'rank' => $rank])) {
                    $brevetRank = $rateGreeting;
                }
            }

            $greeting = $brevetRank;

        } else {
            $brevetRank = '';
        }

        return [$greeting, $permRank, $brevetRank];
    }

    private function _getRateTitle($params)
    {
        $rateDetail = Rating::where('rate_code', '=', $params['rating'])->get();

        if (isset($rateDetail[0]->rate[$params['branch']][$params['rank']]) === true && empty($rateDetail[0]->rate[$params['branch']][$params['rank']]) === false) {
            return $rateDetail[0]->rate[$params['branch']][$params['rank']];
        }
    }

}
