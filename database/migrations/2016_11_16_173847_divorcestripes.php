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
        "display_order":  30,
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
            Award::create($award);
        }
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
