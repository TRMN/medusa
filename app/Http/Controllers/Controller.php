<?php

namespace App\Http\Controllers;

use App\Audit\MedusaAudit;
use App\Permissions\MedusaPermissions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

//        if (isset(Auth::user()->forcepwd)) {
//            return response()->view(
//                'password.request',
//                ['email_address' => Auth::user()->email_address,
//                 'message'       => 'You are required to reset your password at this time.',
//                ]);
//        }

        View::share('permsObj', $this);
        View::share('user', Auth::user());
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
