<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tt05211InsertSfcProbationalPaygrades extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $grades = [
            'P-1' => [
                'SFC' => 'Provisional Ranger I',
            ],
            'P-2' => [
                'SFC' => 'Provisional Ranger II',
            ],
            'P-3' => [
                'SFC' => 'Provisional Ranger III',
            ],
            'P-4' => [
                'SFC' => 'Senior Provisional Ranger',
            ],
        ];

        foreach ($grades as $grade => $titles) {
            $record = App\Grade::where('grade', '=', $grade)->first();

            if (empty($record) === true) {
                // Grade does not exist, we must create it
                $record = new App\Grade();

                $record->grade = $grade;
                $record->rank = $titles;

                $this->writeAuditTrail(
                    'system user',
                    'insert',
                    'grades',
                    null,
                    $record->toJson(),
                    'update_rank_titles'
                );
            } else {
                // Update the existing record
                $record->rank = $titles;

                $this->writeAuditTrail(
                    'system user',
                    'update',
                    'grades',
                    $record->id,
                    $record->toJson(),
                    'update_rank_titles'
                );
            }

            $record->save();
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
