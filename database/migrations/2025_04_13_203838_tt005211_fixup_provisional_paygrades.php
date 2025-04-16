<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class Tt005211FixupProvisionalPaygrades extends Migration
{
    use App\Audit\MedusaAudit;

    /**
     * Update the user to change the rank and add a history entry.
     *
     * @param User $user
     * @param string $toRank
     * @param string $message
     * @return void
     */
    protected function updateUser(User $user, string $toRank, string $message): void
    {
        $rank = $user->rank;
        $rank['grade'] = $toRank;
        $user->rank = $rank;

        $history = $user->history;
        $history[] = [
            'timestamp' => time(),
            'event' => $message,
        ];
        $user->history = $history;

        $this->writeAuditTrail(
            'system user',
            'update',
            'rank',
            null,
            $user->toJson(),
            'fixup_provisional_paygrades'
        );
        $user->save();
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
        $lookingFor = 'Rank changed from Senior Cadet Ranger (C-6) to Ranger(C-7)';

        $history = $user->history;

        foreach ($history as $entry) {
            if (strncmp($entry['event'], $lookingFor, strlen($lookingFor))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Loop through users with C-1 status and convert them to P-1.
     *
     * @return void
     */
    protected function c1ToP1()
    {
        $fromRank = 'C-1';
        $toRank = 'P-1';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Cadet Ranger One (C-1) to Provisional Ranger I (P-1) on {$timestr}";

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromRank)->get();

        foreach ($users as $user) {
            $this->updateUser($user, $toRank, $message);
        }
    }

    /**
     * Loop through users with C-2 status and convert them to P-2.
     *
     * @return void
     */
    protected function c2ToP2()
    {
        $fromRank = 'C-2';
        $toRank = 'P-2';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Cadet Ranger Two (C-2) to Provisional Ranger II (P-2) on {$timestr}";

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromRank)->get();

        foreach ($users as $user) {
            $this->updateUser($user, $toRank, $message);
        }
    }

    /**
     * Loop through users with C-3 status and convert them to P-3.
     *
     * @return void
     */
    protected function c3ToP3()
    {
        $fromRank = 'C-3';
        $toRank = 'P-3';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Cadet Ranger Three (C-3) to Provisional Ranger III (P-3) on {$timestr}";

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromRank)->get();

        foreach ($users as $user) {
            $this->updateUser($user, $toRank, $message);
        }
    }

    /**
     * Loop through users with C-6 status and convert them to P-4.
     *
     * @return void
     */
    protected function c6ToP4()
    {
        $fromRank = 'C-6';
        $toRank = 'P-4';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Senior Cadet Ranger (C-6) to Senior Provisional Ranger (P-4) on {$timestr}";

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromRank)->get();

        foreach ($users as $user) {
            $this->updateUser($user, $toRank, $message);
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
        $fromRank = 'C-7';
        $toRank = 'C-1';
        $time = now();
        $timestr = $time->format('d M Y');
        $message = "Rank changed from Ranger (C-7) to Assistant Ranger (C-1) on {$timestr}";

        $users = User::where('branch', 'SFC')->where('rank.grade', $fromRank)->get();

        foreach ($users as $user) {
            if ($this->checkC6toC7($user)) {
                $this->updateUser($user, $toRank, $message);
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
        $this->c1ToP1();
        $this->c2ToP2();
        $this->c3ToP3();
        $this->c6ToP4();
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
