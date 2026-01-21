<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class FixRmmmDefaultRating extends Migration
{
    use App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::where('branch', 'RMMM')
            ->where('registration_status', 'Active')
            ->where(function ($query) {
                $query->whereNull('rating')
                      ->orWhere('rating', '');
            })
            ->get();

        foreach ($users as $user) {


            $user->rating = 'CATERING';

            $history = $user->history;
            $history[] = [
                'timestamp' => time(),
                'event' => 'Default rating set to CATERING for RMMM user',
            ];
            $user->history = $history;

            $this->writeAuditTrail(
                'system user',
                'update',
                'user',
                null,
                $user->toJson(),
                'fix_rmmm_default_rating'
            );

            $user->save();
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
