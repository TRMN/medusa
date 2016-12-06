<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Audit\MedusaAudit;
use App\Permissions\MedusaPermissions;

class Controller extends BaseController
{

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    use MedusaPermissions;
    use MedusaAudit;

    public function __construct()
    {
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
        if (!is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }
}
