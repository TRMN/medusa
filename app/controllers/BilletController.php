<?php

class BilletController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /billet
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('billets.index');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /billet/create
	 *
	 * @return Response
	 */
	public function create()
	{
        if (($redirect = $this->checkPermissions('ADD_BILLET')) !== true) {
            return $redirect;
        }
        
		return View::make("billet.create");
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /billet
	 *
	 * @return Response
	 */
	public function store()
	{
		if (($redirect = $this->checkPermissions('ADD_BILLET')) !== true) {
            return $redirect;
        }
        
        $validator = Validator::make($data = Input::all(), Billet::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        
        $this->writeAuditTrail(
             Auth::user()->id,
            'create',
            'billet',
            null,
            json_encode($data),
            'BilletController@store'
        );
        
        Billet::create($data);
        
        return Redirect::route('billet.index');
	}

	/**
	 * Display the specified resource.
	 * GET /billet/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /billet/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /billet/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /billet/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}