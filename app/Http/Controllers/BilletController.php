<?php

class BilletController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /billet
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('EDIT_BILLET', 'DEL_BILLET')) !== true) {
            return $redirect;
        }

        return View::make('billet.index');
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
    public function edit(Billet $billet)
    {
        if (($redirect = $this->checkPermissions('EDIT_BILLET')) !== true) {
            return $redirect;
        }

        return View::make("billet.edit", ['billet' => $billet]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /billet/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Billet $billet)
    {
        if (($redirect = $this->checkPermissions('EDIT_BILLET')) !== true) {
            return $redirect;
        }

        $validator = Validator::make($data = Input::all(), Billet::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $billet->billet_name = $data['billet_name'];

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'billet',
            null,
            $billet->toJson(),
            'BilletController@update'
        );

        $billet->save();

        // Update all users that have this billet

        foreach (User::where('assignment.billet', '=', $data['old_name'])->get() as $user) {
            if (empty($user->assignment) === false) {
                $assignment = $user->assignment;
                foreach ($assignment as $index => $value) {
                    if ($value['billet'] === $data['old_name']) {
                        $value['billet'] = $data['billet_name'];
                        $assignment[$index] = $value;
                    }
                }
            }

            $user->assignment = $assignment;

            $this->writeAuditTrail(
                Auth::user()->id,
                'update',
                'user',
                null,
                $user->toJson(),
                'BilletController@update'
            );

            $user->save();
        }

        return Redirect::route('billet.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /billet/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Billet $billet)
    {
        try {
            $billet->delete();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
