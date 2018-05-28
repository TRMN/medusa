<?php

namespace App\Listeners;

use App\Events\GradeEntered;
use App\Mail\McamNotice;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

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
     * @throws \Exception
     */
    public function handle($event)
    {
        if ($event->user->mcamQual() === true) {
            // Send a notice to BuTrain.
            Mail::to(config('awards.MCAM-notification.email'))->send(new McamNotice($event->user));
        }
    }
}
