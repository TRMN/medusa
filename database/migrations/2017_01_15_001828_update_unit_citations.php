<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUnitCitations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $transform = [
          'LHC' => 'LOH',
          'RUC' => 'RUCG',
          'RMU' => 'RMUC',
        ];

        foreach ($transform as $old => $new) {
            $ribbon = \App\Models\Award::where('code', '=', $old)->first();
            $ribbon->code = $new;

            if ($new === 'LOH') {
                $ribbon->multiple = false;
            }

            $ribbon->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $transform = [
          'LHC' => 'LOH',
          'RUC' => 'RUCG',
          'RMU' => 'RMUC',
        ];

        foreach ($transform as $old => $new) {
            $ribbon = \App\Models\Award::where('code', '=', $new)->first();
            $ribbon->code = $old;

            if ($new === 'LOH') {
                $ribbon->multiple = true;
            }

            $ribbon->save();
        }
    }
}
