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
    public function handle(GradeEntered $event)
    {
        if ($event->user->hasAward('ESWP') === true || $event->user->hasAward('OSWP') === true) {
            // If they're not qualified for a SWP, they can't qual for a MCAM

            $numExams = count($event->user->getExamList());
            $numMCAM = 0;

            if ($numExams > 40) {
                // Qualified for at least one MCAM

                $numMCAM++;

                // How many extra do they qualify for?

                $numExams -= 40;

                $numMCAM += (int)($numExams / 35);
            }

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
                    ]
                ]);
            }
        }
    }
}
