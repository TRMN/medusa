<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{

    use DispatchesJobs, ValidatesRequests;
    use Medusa\Permissions\MedusaPermissions;
    use Medusa\Audit\MedusaAudit;

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
