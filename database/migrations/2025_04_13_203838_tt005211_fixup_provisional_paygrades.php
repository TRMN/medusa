<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class Tt005211FixupProvisionalPaygrades extends Migration
{
    use App\Audit\MedusaAudit;

    protected $fromGrades = [
        'C-1' => 'Cadet Ranger One',
        'C-2' => 'Cadet Ranger Two',
        'C-3' => 'Cadet Ranger Three',
        'C-6' => 'Senior Cadet Ranger'
    ];

    /**
     * Update the user to change the rank and add a history entry.
     *
     * @param User $user
     * @param string $fromGrade
     * @param string $toGrade
     * @param string $billet
     * @param string $message
     * @return void
     */
    protected function updateUser(User $user, string $fromGrade, string $toGrade, string $billet, string $message): void
    {
        $rank = $user->rank;
        $rank['grade'] = $toGrade;
        $user->rank = $rank;

        $assignments = $user->assignment;
        if (count($assignments) === 1) {
            $assignments[0]['billet'] = $billet;
            $user->assignment = $assignments;
        } else {
            echo "Multiple assignments for {$user->first_name} {$user->last_name} ({$user->member_id})... fix billet by hand!" . PHP_EOL;
        }

        $history = $user->history;
        $history[] = [
            'timestamp' => time(),
            'event' => $message,
        ];
        $user->history = $history;

        $this->writeAuditTrail(
            'system user',
            'update',
            'user',
            null,
            $user->toJson(),
            'fixup_provisional_paygrades'
        );
        $user->save();
    }

    /**
     * Logic for moving/adjusting paygrade for cadets.
     *
     * @param User $user
     * @return array[string, string, string]
     */
    protected function getToGrade(User $user): array
    {
        $straightMap = [
            'C-1' => 'P-1',
            'C-2' => 'P-2',
            'C-3' => 'P-3',
            'C-6' => 'P-4',
        ];

        $time = now();
        $timestr = $time->format('d M Y');

        $fromGrade = $user->rank['grade'];

        $age = $user->getAge();

        switch ($age) {
            case $age <= 11:
                $toGrade = 'P-1';
                $billet = 'Cadet Ranger';
                break;
            case $age <= 13:
                $toGrade = 'P-2';
                $billet = 'Cadet Ranger';
                break;
            case $age <= 15:
                $toGrade = 'P-3';
                $billet = 'Cadet Ranger';
                break;
            case $age <= 17:
                $toGrade = 'P-4';
                $billet = 'Cadet Ranger';
                break;
            default:
                $toGrade = 'C-1';
                $billet = 'Civilian';
        }

        $message = "Rank adjusted from {$this->fromGrades[$fromGrade]} ({$fromGrade}) to {$billet} ({$toGrade}) per PD-BOD-4100 on {$timestr}";

        if ($straightMap[$fromGrade] != $toGrade) {
            echo "Adjusted {$user->first_name} {$user->last_name} ({$user->member_id}) from {$straightMap[$fromGrade]} to $toGrade" . PHP_EOL;
        }

        return [$toGrade, $billet, $message];
    }

    /**
     * Check the user's service history and see if they made the old C-6 to C-7
     * transition as they aged out of the provisional cadet status.
     *
     * @param User $user
     * @return bool True if they aged out of provisional cadet status.
     */
    protected function checkC6toC7(User $user): bool
    {
        $lookingFor = 'Rank adjusted from Senior Cadet Ranger (C-6) to Ranger(C-7)';

        $history = $user->history;

        foreach ($history as $entry) {
            if (strncmp($entry['event'], $lookingFor, strlen($lookingFor))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Loop through users with C-6 status and convert them to P-4.
     *
     * @return void
     */
    protected function civilianToProvisional()
    {
        foreach ($this->fromGrades as $fromGrade => $fromBillet) {
            echo "Migrating {$fromGrade}..." . PHP_EOL;
            $users = User::where('branch', 'SFC')->where('rank.grade', $fromGrade)->get();

            foreach ($users as $user) {
                [$toGrade, $billet, $message] = $this->getToGrade($user);

                $this->updateUser($user, $fromGrade, $toGrade, $billet, $message);
            }
        }
    }

    /**
     * Loop through users with C-7 status and convert them to C-1 if they have
     * the history indicating they aged out of provisional cadet status.
     *
     * @return void
     */
    protected function c7toC1()
    {
        $fromGrade = 'C-7';
        $toGrade = 'C-3';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Ranger (C-7) to Assistant Ranger (C-3) per PD-BOD-4100 on {$timestr}";

        echo "Migrating {$fromGrade}..." . PHP_EOL;

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromGrade)->get();

        foreach ($users as $user) {
            if ($this->checkC6toC7($user)) {
                $this->updateUser($user, $fromGrade, $toGrade, 'Civilian', $message);
            }
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->civilianToProvisional();
        $this->c7toC1();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
