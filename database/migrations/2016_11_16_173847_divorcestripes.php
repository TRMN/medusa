<?php

use Illuminate\Database\Migrations\Migration;

class Divorcestripes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Clear out the bad entries
        \App\Award::whereIn('code', ['MT', 'WS', 'MID'])->delete();

        // Now add the good ones
        $awards = json_decode('[
    {
        "display_order":  26,
        "name": "Monarch\'s Thanks",
        "code": "MT",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": true
    },
    {
        "display_order":  35,
        "name": "Wound Stripe",
        "code": "WS",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": true
    },
    {
        "display_order":  34,
        "name": "Mentioned in Dispatches",
        "code": "MID",
        "post_nominal": "",
        "replaces": "",
        "location": "RS",
        "multiple": false
    }        
    ]', true);

        foreach ($awards as $award) {
            \App\Award::create($award);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Award::whereIn('code', ['MT', 'WS', 'MID'])->delete();
    }
}
