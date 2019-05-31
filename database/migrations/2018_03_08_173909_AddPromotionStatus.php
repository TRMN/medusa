<?php

use Illuminate\Database\Migrations\Migration;

class AddPromotionStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (App\Models\User::activeUsers() as $member) {
            $member->promotionStatus = $member->isPromotable();
            $member->save();
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
