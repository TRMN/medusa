<?php

use Illuminate\Database\Migrations\Migration;

class FixPeerages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (App\Models\User::all() as $member) {
            if (isset($member->peerages) === true) {
                $member->peerages = array_values($member->peerages);
                $member->save();
            }
        }
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
