<?php

namespace App\Http\Controllers;

use App\Audit\MedusaAudit;
use App\Permissions\MedusaPermissions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

//use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use MedusaPermissions;
    use MedusaAudit;

    public function __construct()
    {
        if (\Auth::check() !== true) {
            redirect()->action('HomeController@index');
        }
        View::share('permsObj', $this);
        View::share('user', Auth::user());

//        $this->middleware('osatos');
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }
}
