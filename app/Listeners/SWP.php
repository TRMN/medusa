<?php

namespace App\Listeners;

use App\Events\GradeEntered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SWP
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
     * @param  GradeEntered  $event
     * @return void
     */
    public function handle(GradeEntered $event)
    {
        //
    }
}
