<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEchelonsUnjoinable extends Migration
{

    use \Medusa\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $types = ['task_force', 'task_group', 'squadron', 'division'];

        foreach ($types as $type) {
            $echelons = Chapter::where('chapter_type', '=', $type)->get();

            foreach ($echelons as $echelon) {
                $echelon->joinable = false;

                $this->writeAuditTrail(
                    'system user',
                    'update',
                    'chapters',
                    (string)$echelon->_id,
                    $echelon->toJson(),
                    'make_echelons_unjoinable'
                );

                $echelon->save();
            }
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
