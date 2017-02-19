<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropExistingOauthTables extends Migration
{
    public function up()
    {
        Schema::drop('oauth_auth_codes');
        Schema::drop('oauth_access_tokens');
        Schema::drop('oauth_refresh_tokens');
        Schema::drop('oauth_clients');
        Schema::drop('oauth_personal_access_clients');
    }

    public function down()
    {

    }
}