<?php

namespace App\Listeners;

use App\Mail\McamNotice;
use App\Models\Events\GradeEntered;
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
     * @param GradeEntered $event
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle($event)
    {
        if ($event->user->mcamQual() === true) {
            // Send a notice to BuTrain.
            Mail::to(config('awards.MCAM-notification.email'))->send(new McamNotice($event->user));
        }
    }
}
