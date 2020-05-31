<?php

use App\Grade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRmacsPaygrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $paygrades = [
            'C-1' => 'Trainee',
            'C-2' => null,
            'C-3' => null,
            'C-4' => 'Petty Officer Third Class',
            'C-5' => 'Petty Officer Second Class',
            'C-6' => 'Petty Officer First Class',
            'C-7' => 'Chief Petty Officer',
            'C-8' => 'Senior Chief Petty Officer',
            'C-9' => 'Master Chief Petty Officer',
            'C-10' => null,
            'C-11' => null,
            'C-12' => 'Ensign',
            'C-13' => 'Lieutenant (JG)',
            'C-14' => 'Lieutenant (SG)',
            'C-15' => 'Lieutenant Commander',
            'C-16' => 'Commander',
            'C-17' => 'Captain',
            'C-18' => 'Commodore',
            'C-19' => 'Rear Admiral',
            'C-20' => 'Vice Admiral',
            'C-21' => 'Admiral',
            'C-22' => 'Transport Minister',
            'C-23' => 'Home Secretary',
        ];

        foreach ($paygrades as $paygrade => $title) {
            $rec = Grade::where('grade', $paygrade)->first();
            $ranks = $rec->rank;
            if (is_null($title)) {
                unset($ranks['RMACS']);
            } else {
                $ranks['RMACS'] = $title;
            }

            $rec->rank = $ranks;
            $rec->save();
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
