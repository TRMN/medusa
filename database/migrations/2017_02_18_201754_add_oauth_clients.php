<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $client = new \App\OAuthClient;
        $client->client_id = 'butrainmoodle';
        $client->secret = 'KcPNE5NvDSbFztgOWn9gYvF4iEw8yHNPH0HrYK4W';
        $client->name = 'BuTrain Testing';
        $client->redirect = 'http://kr1ma.com/kr1ma_moodle29/auth/medusaoauth2/medusa_redirect.php';
        $client->revoked = false;
        $client->save();

        $client = new \App\OAuthClient;
        $client->user_id = null;
        $client->name = 'MEDUSA Mobile';
        $client->secret = '';
        $client->personal_access_client = false;
        $client->password_client = true;
        $client->revoked = false;
        $client->redirect = '';
        $client->client_id = 'medusamobile';
        $client->save();

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
