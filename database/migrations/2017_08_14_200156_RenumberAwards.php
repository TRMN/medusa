<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Award;

class RenumberAwards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $awards = Award::where('display_order', '>=', 3)->where('display_order', '<', 1000)->increment('display_order', 1);

        // Deal with a few oddities -- sleeve stripes need to be pulled out into their own section

        Award::where('code', 'MT')->update(['display_order' => 3000]);
        Award::where('code', 'MID')->update(['display_order' => 3001]);
        Award::where('code', 'WS')->update(['display_order' => 3002]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $awards = Award::where('display_order', '>=', 4)->where('display_order', '<', 1000)->decrement('display_order', 1);
    }
}

/*
26 Monarch's Thanks (MT) 38
34 Mentioned in Dispatches (MID) 50
37 Wound Stripe (WS) 44
 */