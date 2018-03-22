<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Branch;

class SFS2SFC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update the SFS entry in the branch's collection

        $item = App\Branch::where('branch', 'SFS')->first();

        $item->branch = 'SFC';
        $item->branch_name = 'Sphinx Forestry Commission';

        $item->save();

        // Get all the other entries and update the equivalency entry

        foreach(App\Branch::where('branch', '!=', 'SFC')->get() as $entry) {
            $equivalent = $entry->equivalent;
            $equivalent['SFC'] = $equivalent['SFS'];
            unset($equivalent['SFS']);

            $entry->equivalent = $equivalent;
            $entry->save();
        }

        // Update all the members branch

        foreach(\App\User::where('branch', 'SFS')->get() as $member) {
            $member->branch = 'SFC';
            $member->save();
        }

        // Update the gpa patterns

        $gpa = \App\MedusaConfig::get('gpa.patterns');
        $gpa['services']['SFC'] = '/^SIA-SFC-';

        \App\MedusaConfig::set('gpa.patterns', $gpa);

        // Update the exam regex

        $exams = App\MedusaConfig::get('exam.regex');
        $exams['SFC'] = $exams['SFS'];
        unset($exams['SFS']);

        \App\MedusaConfig::set('exam.regex', $exams);

        // Update the rank tables

        foreach(\App\Grade::where('grade', 'like', 'C-%')->get() as $grade) {
            if (empty($grade->rank['SFS']) === false) {
                $rank = $grade->rank;
                $rank['SFC'] = $rank['SFS'];
                unset($rank['SFS']);
                $grade->rank = $rank;
                $grade->save();
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
        // Reverse the change

        $item = Branch::where('branch', 'SFC')->first();

        $item->branch = 'SFS';
        $item->branch_name = 'Civil Service/Sphinx Forestry Service';

        $item->save();

        // Get all the other entries and update the equivalency entry

        foreach(Branch::where('branch', '!=', 'SFS')->get() as $entry) {
            $equivalent = $entry->equivalent;
            $equivalent['SFS'] = $equivalent['SFC'];
            unset($equivalent['SFC']);

            $entry->equivalent = $equivalent;
            $entry->save();
        }

        // Update all the members branch

        foreach(\App\User::where('branch', 'SFC')->get() as $member) {
            $member->branch = 'SFS';
            $member->save();
        }

        // Revert the gpa patterns

        $gpa = \App\MedusaConfig::get('gpa.patterns');
        unset($gpa['services']['SFC']);

        \App\MedusaConfig::set('gpa.patterns', $gpa);

        // Revert the exam regex

        $exams = App\MedusaConfig::get('exam.regex');
        $exams['SFS'] = $exams['SFC'];
        unset($exams['SFC']);

        \App\MedusaConfig::set('exam.regex', $exams);

        // Revert the rank tables

        foreach(\App\Grade::where('grade', 'like', 'C-%')->get() as $grade) {
            if (empty($grade->rank['SFC']) === false) {
                $rank = $grade->rank;
                $rank['SFS'] = $rank['SFC'];
                unset($rank['SFC']);
                $grade->rank = $rank;
                $grade->save();
            }
        }
    }
}
