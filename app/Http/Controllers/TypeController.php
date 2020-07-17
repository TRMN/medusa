<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /billet.
     *
     * @return Response
     */
    public function index()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view('type.index');
    }

    /**
     * Show the form for creating a new resource.
     * GET /billet/create.
     *
     * @return Response
     */
    public function create()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view('type.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /billet.
     *
     * @return Response
     */
    public function store()
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $data = Request::all();

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
     * GET /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /billet/{id}/edit.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(Type $type)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        return view('type.edit', ['type' => $type]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Type $type)
    {
        if (($redirect = $this->checkPermissions('ALL_PERMS')) !== true) {
            return $redirect;
        }

        $oldValue = null;

        $data = Request::all();

        if ($data['chapter_type'] !== $type->chapter_type) {
            $oldValue = $type->chapter_type;
        }

        $this->writeAuditTrail(
            (string) Auth::user()->_id,
            'update',
            'types',
            (string) $type->_id,
            json_encode($data),
            'TypeController@update'
        );

        $type->update($data);

        if (empty($oldValue) === false) {
            Chapter::where('chapter_type', '=', $oldValue)->update(['chapter_type' => $data['chapter_type']]);
        }

        Cache::flush();

        return Redirect::route('type.index');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /billet/{id}.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
