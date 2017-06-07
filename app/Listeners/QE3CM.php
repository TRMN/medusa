<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class QE3CM
 * @package App\Listeners
 *
 * Event listener that is subscribed to the LoginComplete Event that will check if the user is Active, has a registration
 * date before 01 JAN 2018 and does not have the Queen Elizabeth III Coronation Medal.  If they do not have the QE3CM,
 * it will be added to their awards record
 */

class QE3CM
{
    use DateQualification;

    /**
     * Handle the event.
     *
     * @param  LoginComplete  $event
     * @return void
     */

    public function handle(LoginComplete $event)
    {
        $this->coronationAndJubilee($event->user, 'QE3CM', '2018-01-01');
    }
}
