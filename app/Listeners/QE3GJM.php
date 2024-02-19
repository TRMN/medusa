<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;

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
        $this->checkAwardDateQualification($event->user, 'QE3GJM', '2027-02-01', '2028-02-01');
    }
}
