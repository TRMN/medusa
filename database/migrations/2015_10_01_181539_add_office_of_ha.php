<?php

use App\Chapter;
use Illuminate\Database\Migrations\Migration;

class AddOfficeOfHa extends Migration
{
    use \App\Audit\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createChapter('Office of the High Admiral (GSN)', 'headquarters', '', 'GSN', null, false);
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

    public function createChapter($name, $type = 'ship', $hull_number = '', $branch = '', $assignedTo = null, $joinable = true, $commissionDate = null)
    {
        $query = Chapter::where('chapter_name', '=', $name)->first();

        if (empty($query->id) === true) {
            $record = [
                'chapter_name' => $name,
                'chapter_type' => $type,
                'hull_number' => $hull_number,
                'branch' => $branch,
                'joinable' => $joinable,
            ];

            if (is_null($assignedTo) === false) {
                $record['assigned_to'] = $assignedTo;
            }

            if (is_null($commissionDate) === false) {
                $record['commission_date'] = $commissionDate;
            }

            $this->writeAuditTrail(
                'system user',
                'create',
                'chapters',
                null,
                json_encode($record),
                'create rmmc chapters'
            );

            return Chapter::create($record);
        }

        echo "Skipping $name, unit already exists.\n";

        return $query;
    }
}
