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

        // Figure out the correct rank title to use for this user based on branch
        $branch = $user->branch;
        $rank = $user->rank['permanent_rank']['grade'];

        if (isset($user->rank['brevet_rank']) === true && empty($user->rank['brevet_rank']) === false) {
            //$rank = $user->rank['brevet_rank']['grade'];
        }

        $gradeDetail = Grade::where('grade', '=', $rank)->get();

        $greeting = $gradeDetail[0]->rank[$branch];

        // Check for rating

        if (isset($user->rating) === true && empty($user->rating) === false) {
            // Look up to see if there is a special address for this grade and rating

            $rateDetail = Rating::where('rate_code', '=', $user->rating)->get();

            if (isset($rateDetail[0]->rate[$branch][$rank]) === true && empty($rateDetail[0]->rate[$branch][$rank]) === false) {
                $greeting = $rateDetail[0]->rate[$branch][$rank];
            }
        }

        return View::make( 'user.show', [ 'user' => $user, 'greeting' => $greeting ] );
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User $user
     * @return Response
     */
    public function edit( User $user )
    {
        return View::make( 'user.edit', [ 'user' => $user ] );
    }

    /**
     * Update the specified user in storage.
     *
     * @param  User $user
     * @return Response
     */
    public function update( User $user )
    {
        $validator = Validator::make( $data = Input::all(), User::$rules );

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors( $validator )->withInput();
        }

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
        User::destroy( $user->id );

        return Redirect::route( 'user.index' );
    }

}
