<?php

use Illuminate\Database\Migrations\Migration;

class AddReportRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $recipients = [
            'cno@trmn.org',
            'buplan@trmn.org',
            'buships@trmn.org',
            'bupers@trmn.org',
            'homesecretary@trmn.org',
            'sma@rhn.trmn.org',
            'sma@ian.trmn.org',
            'lordnewscania@gmail.com',
            'highadm@gsn.trmn.org',
        ];

        App\Models\MedusaConfig::set('report.recipients', $recipients);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\MedusaConfig::remove('report.recipients');
    }
}
