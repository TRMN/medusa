<?php

class BaseController extends Controller
{
    use Medusa\Permissions\MedusaPermissions;
    use Medusa\Audit\MedusaAudit;

    public function __construct()
    {
        View::share('permsObj', $this);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( !is_null( $this->layout ) ) {
            $this->layout = View::make( $this->layout );
        }
    }
}
