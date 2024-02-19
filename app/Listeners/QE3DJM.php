<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QE3DJM
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->checkAwardDateQualification($event->user, 'QE3DJM', '2032-02-01', '2033-02-01');
    }
}
