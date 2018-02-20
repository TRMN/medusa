<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $collection) {
            $collection->unique('email_address');
            $collection->index('member_id');
            $collection->index('branch');
            $collection->index('registration_status');
            $collection->index('active');
            $collection->index('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $collection) {
           $collection->dropUnique('email_address');
           $collection->dropIndex('member_id');
           $collection->dropIndex('branch');
           $collection->dropIndex('registration_status');
           $collection->dropIndex('active');
           $collection->dropIndex('path');
        });
    }
}
