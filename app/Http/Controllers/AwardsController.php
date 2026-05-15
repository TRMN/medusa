<?php

namespace App\Http\Controllers;

class AwardsController extends Controller
{
    public function index()
    {
        if (($redirect = $this->checkPermissions('MANAGE_AWARDS')) !== true) {
            return $redirect;
        }

        return view('awards.index');
    }

    public function list()
    {
        // this returns the contents of the rendered template to the client as a string
        return \Illuminate\Support\Facades\View::make("awards.body")->render();
    }
}
