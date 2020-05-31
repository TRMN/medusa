<?php

use Illuminate\Database\Migrations\Migration;

class GpaPatterns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = [
            'services' => [
                'RMN' => '/^SIA-RMN-',
                'RMMC' => '/^SIA-RMMC-',
                'RMA' => '/^KR1MA-RMA-',
                'GSN' => '/^IMNA-GSN-',
                'RMACS' => '/^SIA-RMACS-',
                'IAN' => '/^PAA-IAN-',
                'RMMM' => '/^SIA-RMMM-',
            ],
            'courses' => [
                'enlisted' => '000[1-9]/',
                'warrant' => '001[1-9]$/',
                'officer' => '01[0-9][1-9]$/',
                'flag' => '[12]00[1-9]S?$/',
            ],
        ];

        \App\MedusaConfig::set('gpa.patterns', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('gpa.patterns');
    }
}
