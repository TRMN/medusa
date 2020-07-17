<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;

/**
 * Class KR3CM.
 */
class KR3CM
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
        $this->coronationAndJubilee($event->user, 'KR3CM', '2012-02-05');
    }
}
