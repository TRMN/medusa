<?php

use App\Rating;
use Illuminate\Database\Migrations\Migration;

class Tt005211UpdateRmmmBasicRatings extends Migration
{
    use \App\Audit\MedusaAudit;
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ratings = [
            'rate_code' => 'BASIC',
            'rate' => [
                'description' => 'RMMM Basic Division',
                'RMMM' => [
                    'C-1' => 'Apprentice Spacer',
                    'C-2' => 'General Vessel Assistant',
                    'C-3' => 'Spacer I',
                    'C-4' => 'Spacer II',
                    'C-5' => 'Spacer III',
                    'C-6' => 'Spacer IV',
                    'C-7' => 'Spacer V',
                    'C-8' => 'Spacer VI',
                ],
            ],
        ];

        $this->writeAuditTrail(
            'system_user',
            'insert',
            'ratings',
            null,
            json_encode($ratings),
            'update_rank_titles'
        );

        Rating::insert($ratings);
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
