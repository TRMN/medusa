<?php

class ShipController extends \BaseController {

    /**
     * Display a listing of ships
     *
     * @return Response
     */
    public function index()
    {
        $ships = Ship::all();

        return View::make('ship.index', compact('ships'));
    }

    /**
     * Show the form for creating a new ship
     *
     * @return Response
     */
    public function create()
    {
        foreach( User::select( 'id', 'first_name', 'last_name' )->orderBy( 'id','asc' )->get() as $user ) {
            $users[ $user->id ] = $user->first_name . ' ' . $user->last_name;
        }

        $ship = new Ship;

        return View::make('ship.create', [ 'ship' => $ship, 'users' => $users ] );
    }

    /**
     * Store a newly created ship in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make( $data = Input::all(), Ship::$rules );

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $chapterData = [ 'title' => $data[ 'title' ], 'co' => $data[ 'co' ] ];
        $shipData = [ 'xo' => $data[ 'xo' ], 'bosun' => $data[ 'bosun' ] ];

        Chapter::createChapter( 'Ship', $chapterData, $shipData );

        return Redirect::route('ship.index');
    }

    /**
     * Display the specified ship.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $ship = Ship::findOrFail($id);

        return View::make('ship.show', compact('ship'));
    }

    /**
     * Show the form for editing the specified ship.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ship = Ship::find($id);

        return View::make('ship.edit', compact('ship'));
    }

    /**
     * Update the specified ship in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $ship = Ship::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Ship::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ship->update($data);

        return Redirect::route('ship.index');
    }

    /**
     * Remove the specified ship from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Ship::destroy($id);

        return Redirect::route('ship.index');
    }

    /**
     * Add the specified member to the ship's roster.
     *
     * @param  int  $userId
     * @param  int  $shipId
     * @return Response
     */
    public function addMember( $userId, $shipId )
    {
        $ship = Ship::findOrFail( $shipId );
        $user = User::findOrFail( $userId );

        $ship->members()->attach( $userId );

        return Redirect::route( 'ship.show', [ 'ship' => $ship->id ]);
    }

    /**
     * Remove the specified member from the ship's roster.
     *
     * @param  int  $userId
     * @param  int  $shipId
     * @return Response
     */
    public function removeMember( $userId, $shipId )
    {
        $ship = Ship::findOrFail( $shipId );
        $user = User::findOrFail( $userId );

        $ship->members()->detach( $userId );

        return Redirect::route( 'ship.show', [ 'ship' => $ship->id ]);
    }
}
