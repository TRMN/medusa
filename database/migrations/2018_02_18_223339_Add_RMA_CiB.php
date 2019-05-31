<?php

use Illuminate\Database\Migrations\Migration;

class AddRMACiB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the CIB to the rest of the group

        foreach (\App\Models\Award::where('group_label', 'Qualification Badges')->get() as $badge) {
            $replaces = $badge->replaces;
            $replaces .= ',CIB';
            $badge->replaces = $replaces;
            $badge->save();
        }

        // Now add the CiB
        $cib = [
            'display_order' => 1028,
            'name'          => 'Royal Manticoran Army Combat Infantry Badge',
            'code'          => 'CIB',
            'post_nominal'  => '',
            'replaces'      => 'OSWP,ESWP,HS,SAW,EAW,OAW,ESAW,OSAW,EMAW,OMAW,ENW,ONW,ESNW,OSNW,EMNW,OMNW,EOW,OOW,ESOW,OSOW,EMOW,OMOW,ESW,OSW,ESSW,OSSW,EMSW,OMSW',
            'location'      => 'TL',
            'multiple'      => false,
            'group_label'   => 'Qualification Badges',
            'star_nation'   => 'manticore',
            'points'        => 0,
        ];

        \App\Models\Award::create($cib);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the CIB

        \App\Models\Award::where('code', 'CIB')->delete();

        // Remove the CIB from the group
        foreach (\App\Models\Award::where('group_label', 'Qualification Badges')->get() as $badge) {
            $replaces = $badge->replaces;
            $replaces .= ',CIB';
            $badge->replaces = $replaces;
            $badge->save();
        }
    }
}
