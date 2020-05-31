<?php

namespace App\Http\Controllers;

use App\Permissions\MedusaPermissions;

class PaygradeController extends Controller
{
    use MedusaPermissions;

    public function index()
    {
        if (($redirect = $this->checkPermissions('VIEW_MEMBERS')) !== true) {
            return $redirect;
        }

        return view('paygrades.index');
    }
}
