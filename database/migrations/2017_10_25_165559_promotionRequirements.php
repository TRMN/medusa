<?php

use Illuminate\Database\Migrations\Migration;

class PromotionRequirements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = json_decode('{
  "E-1": {
    "next": [ "E-2" ]
  },
  "C-1": {
    "next": [ "C-2" ]
  },
  "E-2": {
    "next": [ "E-3" ]
  },
  "C-2": {
    "next": [ "C-3" ]
  },
  "E-3": {
    "next": [ "E-4" ]
  },
  "C-3": {
    "next": [ "C-4" ]
  },
  "E-4": {
    "next": [ "E-5" ]
  },
  "C-4": {
    "next": [ "C-5" ]
  },
  "E-5": {
    "next": [ "E-6" ]
  },
  "C-5": {
    "next": [ "C-6" ]
  },
  "E-6": {
    "next": [ "E-7" ]
  },
  "C-6": {
    "next": [ "C-7" ]
  },
  "E-7": {
    "next": [ "E-8" ]
  },
  "C-7": {
    "next": [ "C-8" ]
  },
  "E-8": {
    "next": [ "E-9" ]
  },
  "C-8": {
    "next": [ "C-9" ]
  },
  "E-9": {
    "next": [ "E-10" ]
  },
  "C-9": {
    "next": [ "C-10" ]
  },
  "WO-1": {
    "next": [ "WO-2" ]
  },
  "WO-2": {
    "next": [ "WO-3" ]
  },
  "WO-3": {
    "next": [ "WO-4" ]
  },
  "C-10": {
    "next": [ "C-11" ]
  },
  "WO-4": {
    "next": [ "WO-5" ]
  },
  "O-1": {
    "next": [ "O-2" ]
  },
  "C-12": {
    "next": [ "C-13" ]
  },
  "O-2": {
    "next": [ "O-3" ]
  },
  "C-13": {
    "next": [ "C-14" ]
  },
  "O-3": {
    "next": [ "O-4" ]
  },
  "C-14": {
    "next": [ "C-15" ]
  },
  "O-4": {
    "next": [ "O-5" ]
  },
  "C-15": {
    "next": [ "C-16" ]
  },
  "O-5": {
    "next": [ "O-6", "O-6-A" ]
  },
  "C-16": {
    "next": [ "C-17" ]
  },
  "O-6": {
    "next": [ "F-1" ]
  },
  "C-17": {
    "next": [ "C-18" ]
  },
  "O-6-A": {
    "next": [ "O-6-B" ]
  },
  "O-6-B": {
    "next": [ "F-1" ]
  },
  "F-1": {
    "next": [ "F-2", "F-2-A" ]
  },
  "C-18": {
    "next": [ "C-19" ]
  },
  "F-2": {
    "next": [ "F-3" ]
  },
  "C-19": {
    "next": [ "C-20" ]
  },
  "F-2-A": {
    "next": [ "F-2-B" ]
  },
  "F-2-B": {
    "next": [ "F-3-A" ]
  },
  "F-3": {
    "next": [ "F-4" ]
  },
  "C-20": {
    "next": [ "C-21" ]
  },
  "F-3-A": {
    "next": [ "F-3-B" ]
  },
  "F-3-B": {
    "next": [ "F-4-A" ]
  },
  "F-4": {
    "next": [ "F-5" ]
  },
  "C-21": {
    "next": [ "C-22" ]
  },
  "F-4-A": {
    "next": [ "F-4-B" ]
  },
  "F-4-B": {
    "next": [ "F-5-A" ]
  },
  "F-5": {
    "next": [ "F-6" ]
  },
  "C-22": {
    "next": [ "C-23" ]
  },
  "F-5-A": {
    "next": [ "F-5-B" ]
  },
  "F-5-B": {
    "next": [ "F-6" ]
  }
}', true);

        \App\MedusaConfig::set('pp.nextGrade', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('pp.nextGrade');
    }
}
