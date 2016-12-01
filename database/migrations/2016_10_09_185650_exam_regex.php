<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamRegex extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        MedusaConfig::create([
          'key'   => 'exam.regex',
          'value' => json_decode('
                {
                    "RMN" : "/^SIA-RMN-.*/",
                    "RMN Speciality": "/^SIA-SRN-.*/",
                    "RMMC": "/^SIA-RMMC-.*/",
                    "RMMC Speciality": "/^SIA-SRMC-.*/",
                    "RMA": "/^KR1MA-RMA-.*/",
                    "RMA Speciality": "/^KR1MA-RMAT-.*/",
                    "GSN": "/^IMNA-GSN-.*/",
                    "GSN Speciality": "/^IMNA-(STC|AFLTC|GTSC)-.*/",
                    "Landing University": "/^LU-.*/",
                    "RMACS": "/^SIA-RMACS-.*/",
                    "RMMM": "/^SIA-RMMM-.*/",
                    "Mannheim University": "/^MU-.*/"
                }
		')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MedusaConfig::where('key', '=', 'exam.regex')->firstOrFail()->delete();
    }
}
