<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Award;

class AwardController extends Controller
{
    public function index()
    {
        if (($redirect = $this->checkPermissions('MANAGE_AWARDS')) !== true) {
            return $redirect;
        }

        return view('awards.index');
    }
}
