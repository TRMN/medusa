<?php

use Illuminate\Database\Migrations\Migration;

class MemberListBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $branches = [
            'RMN'   => 'RMN',
            'RMMC'  => 'RMMC',
            'RMA'   => 'RMA',
            'GSN'   => 'GSN',
            'RHN'   => 'RHN',
            'IAN'   => 'IAN',
            'SFS'   => 'SFS',
            'RMACS' => 'RMACS',
            'CIVIL' => 'Civilian',
            'INTEL' => 'Intelligence',
            'RMMM'  => 'Merchant Marine',

        ];

        \App\Models\MedusaConfig::set('memberlist.branches', $branches);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\MedusaConfig::remove('memberlist.branches');
    }
}
