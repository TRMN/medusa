<?php

namespace App\Listeners;

use App\Events\GradeEntered;
use App\MedusaConfig;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle(GradeEntered $event)
    {
        // Get the users exams

        $exams = $event->user->getExamList();

        // Get the qualifications for a SWP

        $swpQual = MedusaConfig::get('awards.swp');

        // Get the branches to check for

        $swpBranches = MedusaConfig::get('awards.swp.branches', ['RMN', 'RMMC']);

        if (is_null($swpQual) === false &&
            in_array($event->user->branch, $swpBranches) === true &&
            $event->user->hasAward('ESWP') === false &&
            $event->user->hasAward('OSWP') === false) {
            // Only process if the qualifications are defined,  it's a branch we check and they don't have an E|O SWP

            $swpType = null;

            switch (substr($event->user->rank['grade'], 0, 1)) {
                case 'E':
                case 'W':
                    $swpType = 'Enlisted';
                    break;
                case 'O':
                case 'F':
                    $swpType = 'Officer';
                    break;
            }

            // Drill down to the specific branch and officer or enlisted

            $swpQual = $swpQual[$event->user->branch][$swpType];

            // Check for required

            $required = null;

            foreach ($swpQual['Required'] as $exam) {
                $required = isset($exams[$exam]);
            }

            // Check the departments

            $departments = [];

            foreach ($swpQual['Departments'] as $dept) {
                foreach ($dept as $exam) {
                    if (isset($exams[$exam])) {
                        $departments[$exam] = true;
                        break;
                    }
                }
            }

            // Do they qualify?

            if ($required === true && count($departments) == $swpQual['NumDepts']) {
                // Yes they do, add it.

            }
        }
    }
}
