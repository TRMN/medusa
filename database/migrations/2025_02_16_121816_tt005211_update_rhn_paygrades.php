<?php

use Illuminate\Database\Migrations\Migration;

class TT005211UpdateRhnPaygrades extends Migration
{
    use \App\Common\UpdatePaygrades;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $branch = 'RHN';
        $paygrades = [
            'E-10' => 'Senior Master Chief Petty Officer',
            // 'F-6' => 'Chief of Naval Operations',
        ];

        $this->update_paygrades($branch, $paygrades);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
