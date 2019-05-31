<?php

use App\Models\MedusaConfig;
use Illuminate\Database\Migrations\Migration;

class AnyUnitChapterTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $chapterTypes = [
            'district',
            'fleet',
            'task_force',
            'task_group',
            'squadron',
            'division',
            'ship',
            'station',
            'headquarters',
            'bivouac',
            'barracks',
            'outpost',
            'fort',
            'planetary',
            'theater',
            'bureau',
            'office',
            'academy',
            'school',
            'corps',
            'exp_force',
            'regiment',
            'shuttle',
            'section',
            'squad',
            'platoon',
            'company',
            'battalion',
            'college',
            'institute',
            'center',
            'university',
            'university_system',
            'keep',
            'barony',
            'county',
            'duchy',
            'grand_duchy',
            'steading',
        ];

        MedusaConfig::set('anyunit.types', $chapterTypes);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        MedusaConfig::remove('anyunit.types');
    }
}
