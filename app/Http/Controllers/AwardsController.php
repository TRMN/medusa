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
}
