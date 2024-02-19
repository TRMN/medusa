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
        $this->checkAwardDateQualification($event->user, 'QE3CM', '2017-01-01', '2018-01-01');
    }
}
