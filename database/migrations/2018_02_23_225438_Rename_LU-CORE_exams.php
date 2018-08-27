<?php

use Illuminate\Database\Migrations\Migration;

class RenameLUCOREExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change the exam_id in the exam_list
        foreach (App\ExamList::where('exam_id', 'like', 'LU-Core-0%')->get() as $exam) {
            $exam->exam_id = str_replace('LU-Core', 'SKU-CORE', $exam->exam_id);
            $exam->save();
        }

        // Change all the exam records
        foreach (App\Exam::all() as $record) {
            $exams = $record->exams;
            if (isset($exams['LU-CORE-01']) === true) {
                $exams['SKU-CORE-01'] = $exams['LU-CORE-01'];
            }
            if (isset($exams['LU-CORE-02']) === true) {
                $exams['SKU-CORE-02'] = $exams['LU-CORE-02'];
            }
            if (isset($exams['LU-CORE-03']) === true) {
                $exams['SKU-CORE-03'] = $exams['LU-CORE-03'];
            }
            if (isset($exams['LU-CORE-04']) === true) {
                $exams['SKU-CORE-04'] = $exams['LU-CORE-04'];
            }
            unset($exams['LU-CORE-01'], $exams['LU-CORE-02'], $exams['LU-CORE-03'], $exams['LU-CORE-04']);

            $record->exams = $exams;

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
        // Change the exam_id in the exam_list
        foreach (App\ExamList::where('exam_id', 'like', 'SKU-CORE-0%')->get() as
                 $exam) {
            $exam->exam_id = str_replace('SKU-CORE', 'LU-Core', $exam->exam_id);
            $exam->save();
        }

        // Change all the exam records
        foreach (App\Exam::all() as $record) {
            $exams = $record->exams;
            if (isset($exams['SKU-CORE-01']) === true) {
                $exams['LU-CORE-01'] = $exams['SKU-CORE-01'];
            }
            if (isset($exams['SKU-CORE-02']) === true) {
                $exams['LU-CORE-02'] = $exams['SKU-CORE-02'];
            }
            if (isset($exams['SKU-CORE-03']) === true) {
                $exams['LU-CORE-03'] = $exams['SKU-CORE-03'];
            }
            if (isset($exams['SKU-CORE-04']) === true) {
                $exams['LU-CORE-04'] = $exams['SKU-CORE-04'];
            }
            unset($exams['SKU-CORE-01'], $exams['SKU-CORE-02'], $exams['SKU-CORE-03'], $exams['SKU-CORE-04']);

            $record->exams = $exams;

            $record->save();
        }
    }
}
