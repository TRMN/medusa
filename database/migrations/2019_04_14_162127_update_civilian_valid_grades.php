<?php

use App\Models\Grade;
use Illuminate\Database\Migrations\Migration;

class UpdateCivilianValidGrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Explicitly remove invalid ranks

        $remove = [
          'C-2' => [
              'RMACS',
          ],
          'C-3' => [
              'RMACS',
          ],
          'C-4' => [
              'SFC',
              'RMMM',
          ],
          'C-5' => [
              'SFC',
              'RMMM',
          ],
          'C-8' => [
              'SFC',
          ],
          'C-9' => [
              'RMMM',
          ],
          'C-10' => [
              'RMMM',
              'RMACS',
          ],
          'C-11' => [
              'SFC',
              'RMMM',
              'RMACS',
          ],
          'C-12' => [
              'SFC',
          ],
          'C-14' => [
              'RMMM',
          ],
        ];

        foreach ($remove as $grade => $branches) {
            $record = Grade::where('grade', $grade)->first();

            if (empty($record) === false) {
                $rank = $record->rank;
                foreach ($branches as $branch) {
                    unset($rank[$branch]);
                }
                $record->rank = $rank;
            }
            $record->save();
        }

        // Be through, check for any we might have missed

        foreach (Grade::all() as $record) {
            $rank = $record->rank;
            foreach ($rank as $branch => $rankTitle) {
                if (empty($rankTitle) === true) {
                    unset($rank[$branch]);
                }
            }
            $record->rank = $rank;
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
