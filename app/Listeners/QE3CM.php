<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;

/**
 * Class QE3CM.
 */
class QE3CM
{
    use DateQualification;

    /**
     * Handle the event.
     *
     * @param LoginComplete $event
     *
     * @return void
     */
    public function handle(LoginComplete $event)
    {
        $this->coronationAndJubilee($event->user, 'QE3CM', '2018-01-01');
    }
}
