<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use App\Events\LoginComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class QE3GJM
 * @package App\Listeners
 *
 * Event listener that is subscribed to the LoginComplete Event that will check if the user is Active, has a registration
 * date before 01 FEB 2028 and does not have the Queen Elizabeth III Gold Jubilee Medal.  If they do not have the QE3GJM,
 * it will be added to their awards record
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
     * @param  LoginComplete  $event
     * @return void
     */
    public function handle(LoginComplete $event)
    {
        $this->coronationAndJubilee($event->user, 'QE3GJM', '2028-02-01');
    }
}
