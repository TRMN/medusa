<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class KR3CM
 * @package App\Listeners
 *
 * Event listener that is subscribed to the LoginComplete Event that will check if the user is Active, has a registration
 * date before 05 FEB 2012 and does not have the King Roger III Coronation Medal.  If they do not have the KR3CM,
 * it will be added to their awards record
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
     * @param  LoginComplete  $event
     * @return void
     */
    public function handle(LoginComplete $event)
    {

        $this->coronationAndJubilee($event->user, 'KR3CM', '2012-02-05');

    }
}
