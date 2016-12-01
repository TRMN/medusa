<?php

class OAuthController extends Controller
{
    public function index()
    {
        if (( $redirect = $this->checkPermissions(['ALL_PERMS']) ) !== true) {
            return $redirect;
        }

        $clients = OauthClient::orderBy('client_name')->get();

        return view('oauth.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /billet/create
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view("oauth.create");
    }

    /**
     * Store a newly created resource in storage.
     * POST /billet
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $validator = Validator::make($data = Input::all(), OauthClient::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'create',
            'oauth_clients',
            null,
            json_encode($data),
            'OauthController@store'
        );

        OauthClient::create($data);

        return Redirect::route('oauthclient.index');
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
    public function edit(OauthClient $oauthClient)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view("oauth.edit", ['oauthclient' => $oauthClient]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /billet/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update(OauthClient $oauthClient)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $validator = Validator::make($data = Input::all(), OauthClient::$updateRules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        foreach (['client_id', 'client_secret', 'redirect_url', 'client_name'] as $property) {
            $oauthClient->{$property} = $data[$property];
        }

        $this->writeAuditTrail(
            Auth::user()->id,
            'update',
            'oauth_client',
            null,
            $oauthClient->toJson(),
            'OAuthController@update'
        );

        $oauthClient->save();

        return Redirect::route('oauthclient.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /billet/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(OauthClient $oauthClient)
    {
        try {
            $oauthClient->delete();
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }
}
