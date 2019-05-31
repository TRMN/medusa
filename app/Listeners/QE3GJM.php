<?php

namespace App\Listeners;

use App\Events\LoginComplete;
use App\Models\Awards\DateQualification;

/**
 * Class QE3GJM.
 */
class QE3GJM
{
    use DateQualification;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param LoginComplete $event
     *
     * @return void
     */
    public function handle(LoginComplete $event)
    {
        $this->coronationAndJubilee($event->user, 'QE3GJM', '2028-02-01');
    }
}
