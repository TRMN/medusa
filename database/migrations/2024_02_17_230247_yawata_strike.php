<?php

use App\Award;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class YawataStrike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Renumber KR3CM to NPHE
        $awards = Award::where('display_order', '>=', 74)->where('display_order', '<', 94)->increment('display_order', 1);

        // Add the Yawata Strike Memorial Ribbon
        Award::create(
            [
                'display_order' => 74,
                'name' => 'Yawata Strike Memorial Ribbon',
                'code' => 'YSMR',
                'post_nominal' => '',
                'replaces' => '',
                'location' => 'L',
                'multiple' => false,
                'points' => 2,
                'star_nation' => 'manticore',
            ]
        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Undo renumber KR3CM to NPHE
        $awards = Award::where('display_order', '>=', 75)->where('display_order', '<', 94)->decrement('display_order', 1);

        // Remove the Yawata Strike Memorial Ribbon
        Award::where('code', 'YSMR')->delete();

    }
}
