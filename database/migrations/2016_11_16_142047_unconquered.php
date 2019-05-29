<?php

use Illuminate\Database\Migrations\Migration;

class Unconquered extends Migration
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
        "display_order":  2000,
        "name": "HMS UNCONQUERED",
        "code": "UNC",
        "post_nominal": "",
        "replaces": "",
        "location": "LS",
        "multiple": false
    }
    ]', true);

        foreach ($awards as $award) {
            \App\Models\Award::create($award);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Award::whereIn('code', ['UNC'])->delete();
    }
}
