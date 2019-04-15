<?php

namespace App\Listeners;

use App\Events\LoginComplete;
use App\Awards\DateQualification;

/**
 * Class QE3SJM.
 */
class QE3SJM
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
        $this->coronationAndJubilee($event->user, 'QE3SJM', '2023-02-01');
    }
}
