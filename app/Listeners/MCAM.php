<?php

namespace App\Listeners;

use App\Events\GradeEntered;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MCAM
{
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
     * @param  GradeEntered $event
     *
     * @return void
     */
    public function handle($event)
    {
        $event->user->mcamQual();
    }
}
