<?php

class UserController extends \BaseController {

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
		return View::make( 'user.create' );
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make( $data = Input::all(), User::$rules );

		if ( $validator->fails() )
		{
			return Redirect::back()->withErrors( $validator )->withInput();
		}

		User::create( $data );

		return Redirect::route( 'user.index' );
	}

	/**
	 * Display the specified user.
	 *
	 * @param  User   $user
	 * @return Response
	 */
	public function show( User $user )
	{
		return View::make( 'user.show', [ 'user' => $user ] );
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  User   $user
	 * @return Response
	 */
	public function edit( User $user )
	{
		return View::make( 'user.edit', [ 'user' => $user ] );
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  User  $user
	 * @return Response
	 */
	public function update( User $user )
	{
		$validator = Validator::make( $data = Input::all(), User::$rules );

		if ( $validator->fails() )
		{
			return Redirect::back()->withErrors( $validator )->withInput();
		}

		$user->update( $data );

		return Redirect::route( 'user.index' );
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  User  $user
	 * @return Response
	 */
	public function destroy( User $user )
	{
		User::destroy( $user->id );

		return Redirect::route( 'user.index' );
	}

}
