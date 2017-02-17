<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSMCPON extends Migration
{

    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $firstSL = \App\Chapter::where('chapter_name', '=', 'Office of the First Space Lord')->first();

        $this->createChapter('Office of the Senior Master Chief Petty Officer of the Navy', 'bureau', '', 'RMN', $firstSL->id, false);
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

    function createChapter(
        $name,
        $type = "ship",
        $hull_number = '',
        $branch = '',
        $assignedTo = null,
        $joinable = true,
        $commisionDate = null
    ) {
        $query = \App\Chapter::where('chapter_name', '=', $name)->first();

        if (empty($query->id) === true) {
            $record =
                [
                    'chapter_name' => $name,
                    'chapter_type' => $type,
                    'hull_number'  => $hull_number,
                    'branch'       => $branch,
                    'joinable'     => $joinable
                ];

            if (is_null($assignedTo) === false) {
                $record['assigned_to'] = $assignedTo;
            }

            if (is_null($commisionDate) === false) {
                $record['commission_date'] = $commisionDate;
            }

            $this->writeAuditTrail(
                'system user',
                'create',
                'chapters',
                null,
                json_encode($record),
                'create rmmc chapters'
            );
            return \App\Chapter::create($record);
        } else {
            echo "Skipping " . $name . ", unit already exists.\n";
            return $query;
        }
    }
}
