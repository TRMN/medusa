<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Rating;

class UpdateSis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $rate = Rating::where('rate_code', 'INTEL')->first();
        $newRate = $rate->rate;
        $newRate['description'] = "Special Intelligence Service";
        $rate->rate = $newRate;
        $rate->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      $rate = Rating::where('rate_code', 'INTEL')->first();
      $newRate = $rate->rate;
      $rate->rate['description'] = "Intelligence Corps";
      $rate->rate = $newRate;
      $rate->save();
    }
}
