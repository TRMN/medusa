<?php

namespace App\Listeners;

use App\Events\LoginComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class QE3CM
 * @package App\Listeners
 *
 * Event listener that is subscribed to the LoginComplete Event that will check if the user is Active, has a registration
 * date before 01 JAN 2017 and does not have the Queen Elizabeth III Coronation Medal.  If they do not have the QE3CM,
 * it will be added to their awards record
 */

class QE3CM
{
    /**
     * Handle the event.
     *
     * @param  LoginComplete  $event
     * @return void
     */

    public function handle(LoginComplete $event)
    {
        $user = $event->user;

        if ($user->hasAward('QE3CM') === false &&
            $user->registration_status === 'Active' &&
            strtotime($user->registration_date) < 1483228800) {
            // The user does not have a QE3CM and qualifies, add it

            $awards = $user->awards;

            $awards['QE3CM'] = [
                'count' => 1,
                'location' => 'L',
            ];

            $user->awards = $awards;

            $user->save();
        }
    }
}
