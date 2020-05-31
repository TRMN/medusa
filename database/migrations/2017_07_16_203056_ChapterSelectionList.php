<?php

use App\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class ChapterSelectionList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $selection = [
            [
                'unjoinable' => false,
                'label' => 'Holding Chapters',
                'call' => "App\Chapter::getHoldingChapters",
            ],
            [
                'unjoinable' => true,
                'label' => 'Headquarters',
                'call' => "App\Chapter::getChaptersByType",
                'args' => 'headquarters',
            ],
            [
                'unjoinable' => true,
                'label' => 'Bureaus',
                'call' => "App\Chapter::getChaptersByType",
                'args' => 'bureau',
            ],
            [
                'unjoinable' => true,
                'label' => 'Offices',
                'call' => "App\Chapter::getChaptersByType",
                'args' => 'office',
            ],
            [
                'unjoinable' => true,
                'label' => 'Academies',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'academy',
            ],
            [
                'unjoinable' => true,
                'label' => 'Institutes',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'institute',
            ],
            [
                'unjoinable' => true,
                'label' => 'Universities',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'university',
            ],
            [
                'unjoinable' => true,
                'label' => 'University Systems',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'university_system',
            ],
            [
                'unjoinable' => true,
                'label' => 'Colleges',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'college',
            ],
            [
                'unjoinable' => true,
                'label' => 'Training Centers',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'center',
            ],
            [
                'unjoinable' => true,
                'label' => 'Fleets',
                'url' => '/api/fleet',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'fleet',
            ],
            [
                'unjoinable' => true,
                'label' => 'Task Forces',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'task_force',
            ],
            [
                'unjoinable' => true,
                'label' => 'Task Groups',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'task_group',
            ],
            [
                'unjoinable' => true,
                'label' => 'Squadrons',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'squadron',
            ],
            [
                'unjoinable' => true,
                'label' => 'Divisions',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'division',
            ],
            [
                'unjoinable' => true,
                'label' => 'Separation Units',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'SU',
            ],
            [
                'unjoinable' => true,
                'label' => 'Keeps',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'keep',
            ],
            [
                'unjoinable' => true,
                'label' => 'Baronies',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'barony',
            ],
            [
                'unjoinable' => true,
                'label' => 'Counties',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'county',
            ],
            [
                'unjoinable' => true,
                'label' => 'Duchy',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'duchy',
            ],
            [
                'unjoinable' => true,
                'label' => 'Steadings',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'steadings',
            ],
            [
                'unjoinable' => true,
                'label' => 'Grand Duchy',
                'call' => 'App\Chapter::getChaptersByType',
                'args' => 'grand_duchy',
            ],
            [
                'unjoinable' => false,
                'label' => 'RMN',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RMN',
            ],
            [
                'unjoinable' => false,
                'label' => 'RMMC',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RMMC',
            ],
            [
                'unjoinable' => false,
                'label' => 'RMA',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RMA',
            ],
            [
                'unjoinable' => false,
                'label' => 'GSN',
                'call' => 'App\Chapter::getChapters',
                'args' => 'GSN',
            ],
            [
                'unjoinable' => false,
                'label' => 'IAN',
                'call' => 'App\Chapter::getChapters',
                'args' => 'IAN',
            ],
            [
                'unjoinable' => false,
                'label' => 'RHN',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RHN',
            ],
            [
                'unjoinable' => false,
                'label' => 'SFS',
                'call' => 'App\Chapter::getChapters',
                'args' => 'SFS',
            ],
            [
                'unjoinable' => false,
                'label' => 'CIVIL',
                'call' => 'App\Chapter::getChapters',
                'args' => 'CIVIL',
            ],
            [
                'unjoinable' => false,
                'label' => 'INTEL',
                'call' => 'App\Chapter::getChapters',
                'args' => 'INTEL',
            ],
            [
                'unjoinable' => false,
                'label' => 'RMMM',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RMMM',
            ],
            [
                'unjoinable' => false,
                'label' => 'RMACS',
                'call' => 'App\Chapter::getChapters',
                'args' => 'RMACS',
            ],
        ];

        MedusaConfig::set('chapter.selection', $selection);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MedusaConfig::remove('chapter.selection');
    }
}
