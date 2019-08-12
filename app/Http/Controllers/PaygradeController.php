<?php

namespace App\Http\Controllers;

use App\Permissions\MedusaPermissions;
use Illuminate\Http\Request;

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
