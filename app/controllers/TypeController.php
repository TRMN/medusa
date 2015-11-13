<?php

class TypeController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /billet
     *
     * @return Response
     */
    public function index()
    {
        if (( $redirect = $this->checkPermissions('ALL_PERMS') ) !== true) {
            return $redirect;
        }

        return View::make('type.index');
    }

    /**
     * Show the form for creating a new resource.
     * GET /billet/create
     *
     * @return Response
     */
    public function create()
    {
        if (( $redirect = $this->checkPermissions('ALL_PERMS') ) !== true) {
            return $redirect;
        }

        return View::make("type.create");
    }

    /**
     * Store a newly created resource in storage.
     * POST /billet
     *
     * @return Response
     */
    public function store()
    {
        if (( $redirect = $this->checkPermissions('ALL_PERMS') ) !== true) {
            return $redirect;
        }

        $data = Input::all();

        $this->writeAuditTrail(
            Auth::user()->id,
            'create',
            'type',
            null,
            json_encode($data),
            'TypeController@store'
        );

        Type::create($data);

        return Redirect::route('type.index');
	}

    /**
     * Display the specified resource.
     * GET /billet/{id}
     *
     * @param  int $id
     *
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
     * @param  int $id
     *
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
     * @param  int $id
     *
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
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}