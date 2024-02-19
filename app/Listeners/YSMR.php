<?php

namespace App\Listeners;

use App\Awards\DateQualification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class YSMR
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
        $this->checkAwardDateQualification($event->user, 'YSMR', '2020-01-01', '2023-03-01');

    }
}
