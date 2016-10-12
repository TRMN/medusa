<?php

class ConfigController extends \BaseController
{
    use \Medusa\Audit\MedusaAudit;

    /**
     * Display a listing of the resource.
     * GET /config
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        return View::make('config.index');
    }

    /**
     * Show the form for creating a new resource.
     * GET /config/create
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        return View::make(
          'config.config',
          [
            'action' => 'add',
            'config' => new MedusaConfig(),
          ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * POST /config
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        $data = Input::all();

        $config = new MedusaConfig();

        $config->key = $data['key'];
        $config->value = $data['value'];

        if (is_null(json_decode($data['value'])) === false) {
            // We have a json object and not a string
            $config->value = json_decode($data['value']);
        }

        try {
            $config->save();

            $this->writeAuditTrail(
              (string)Auth::user()->_id,
              'create',
              'config',
              null,
              $config->toJson(),
              'ConfigController@update'
            );

            $msg = '"' . $config->key . '" has been added';
        } catch (Exception $e) {
            $msg =
              'There was a problem saving "' . $config->key . '"';
            log::error($e->getTraceAsString());
        }

        return Redirect::route('config.index')->with('message', $msg);
    }

    /**
     * Display the specified resource.
     * GET /config/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }
    }

    /**
     * Show the form for editing the specified resource.
     * GET /config/{id}/edit
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(MedusaConfig $config)
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        return View::make(
          'config.config',
          [
            'action' => 'edit',
            'config' => $config,
          ]
        );
    }

    /**
     * Update the specified resource in storage.
     * PUT /config/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update(MedusaConfig $config)
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        $data = Input::all();

        $config->key = $data['key'];
        $config->value = $data['value'];

        if (is_null(json_decode($data['value'])) === false) {
            // We have a json object and not a string
            $config->value = json_decode($data['value']);
        }

        try {
            $config->save();

            $this->writeAuditTrail(
              (string)Auth::user()->_id,
              'update',
              'config',
              $config->id,
              $config->toJson(),
              'ConfigController@update'
            );

            $msg = '"' . $config->key . '" has been updated';
        } catch (Exception $e) {
            $msg =
              'There was a problem saving the update to "' . $config->key . '"';
            log::error($e->getTraceAsString());
        }

        return Redirect::route('config.index')->with('message', $msg);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /config/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(MedusaConfig $config)
    {
        if (($redirect = $this->hasPermissions('CONFIG', true)) !== true) {
            return $redirect;
        }

        try {
            $config->delete();

            $this->writeAuditTrail(
              (string)Auth::user()->_id,
              'delete',
              'config',
              $config->id,
              $config->toJson(),
              'ConfigController@delete'
            );

            return 1;
        } catch (Exception $e) {
            log::error($e->getTraceAsString());
            return 0;
        }
    }

}