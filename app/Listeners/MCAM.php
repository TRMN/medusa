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

        $numMCAM = $event->user->mcamQual();

        if ($numMCAM > 0) {
            // Qualified for at least 1 MCAM, update their ribbon rack

            $curNumMCAM = 0;
            $awardDates = [];

            if ($event->user->hasAward('MCAM')) {
                $curNumMCAM = $event->user->awards['MCAM']['count'];
                $awardDates = $event->user->awards['MCAM']['award_date'];
            }

            $newMCAM = $numMCAM - $curNumMCAM;

            $awardDates += array_fill($newMCAM - 1, $newMCAM,
                Carbon::create()->firstOfMonth()->addMonth()->toDateString());

            $event->user->addUpdateAward([
                'MCAM' => [
                    'count' => $numMCAM,
                    'location' => 'L',
                    'award_date' => $awardDates,
                    'display' => true,
                ]
            ]);
        }
    }
}
