<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromotionPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $points = [
            "AFSM" => 1,
            "NCOSCR" => 1,
            "RTR" => 1,
            "NPMC" => 1,
            "NRMC" => 1,
            "NPS" => 2,
            "NRS" => 2,
            "NPE" => 3,
            "NRE" => 3,
            "NPHE" => 4,
            "NRHE" => 4,
            "SSD" => 1,
            "GCM" => 2,
            "MRSM" => 2,
            "MtSM" => 2,
            "MCAM" => 1,
            "QE3CM" => 1,
            "KR3CM" => 1,
            "GACM" => 1,
            "MHW" => 1,
            "HOSM" => 1,
            "HWC" => 1,
            "MOM" => 2,
            "SAPC" => 1,
            "SvC" => 2,
            "POW" => 1,
            "FEA" => 1,
            "RMUC" => 1,
            "RUCG" => 1,
            "LOH" => 2,
            "NMAM" => 1,
            "NCD" => 1,
            "MSM" => 1,
            "CSM" => 1,
            "CBM" => 1,
            "EM" => 0.5,
            "GLM" => 0.5,
            "RM" => 0.5,
            "MID" => 1,
            "RHDSM" => 1,
            "QBM" => 1,
            "WS" => 1,
            "OCN" => 1,
            "GS" => 1,
            "CGM" => 1,
            "MT" => 1,
            "ME" => 1,
            "MGL" => 1,
            "MR" => 1,
            "DSO" => 1,
            "NS" => 1,
            "OG" => 1,
            "OE" => 1.5,
            "OGL" => 1.5,
            "OR" => 1.5,
            "DGC" => 2,
            "SC" => 2,
            "CE" => 2,
            "CGL" => 2,
            "CR" => 2,
            "KE" => 2.5,
            "KGL" => 2.5,
            "KR" => 2.5,
            "OC" => 2,
            "MC" => 2,
            "KCE" => 3,
            "KCGL" => 3,
            "KCR" => 3,
            "KDE" => 3.5,
            "KDGL" => 3.5,
            "KDR" => 3.5,
            "OM" => 3,
            "GCE" => 4,
            "GCGL" => 4,
            "GCR" => 4,
            "KSK" => 4,
            "AC" => 4,
            "QCB" => 4,
            "PMV" => 5,
        ];

        foreach ($points as $code => $value) {
            DB::collection('awards')->where('code', $code)->update(['points' => $value], ['upsert' => true]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::collection('awards')->unset('points');
    }
}
