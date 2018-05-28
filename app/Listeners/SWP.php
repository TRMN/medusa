<?php

namespace App\Listeners;

use App\Events\GradeEntered;

class SWP
{
    /**
     * Determine if a member qualifies for a SWP
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
     * @param  GradeEntered $event
     *
     * @return void
     */
    public function handle($event)
    {
        // Use the method in the AwardQualification trait so we can run a check
        // anywhere

        $event->user->swpQual();
    }
}
