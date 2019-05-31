<?php

use Illuminate\Database\Migrations\Migration;

class NewChapterTypes extends Migration
{
    use \App\Traits\MedusaAudit;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the two new chapter types
        $this->createChapterType('small_craft', 'Small Craft');
        $this->createChapterType('lac', 'Light Attack Craft');

        // Update Pinnace's and LAC's to the new types

        $small_craft =
          \App\Models\Chapter::where('chapter_name', 'like', 'Pinnace%')->get();

        foreach ($small_craft as $pinnace) {
            $this->updateChapter($pinnace, 'small_craft');
        }

        $lacs = \App\Models\Chapter::where('chapter_name', 'like', 'HMLAC%')
              ->orWhere('chapter_name', 'like', 'GSNLAC%')
              ->get();

        foreach ($lacs as $lac) {
            $this->updateChapter($lac, 'lac');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Type::whereIn('chapter_type', ['small_craft', 'lac'])->delete();
    }

    public function updateChapter(App\Models\Chapter $chapter, $type)
    {
        $chapter->chapter_type = $type;

        $this->writeAuditTrail(
            'system user',
            'update',
            'chapters',
            $chapter->id,
            $chapter->toJson(),
            'new_chapter_types'
        );

        $chapter->save();
    }

    public function createChapterType($type, $description, array $can_have = [])
    {
        $this->writeAuditTrail(
            'system user',
            'create',
            'types',
            null,
            json_encode([
            'chapter_type'        => $type,
            'chapter_description' => $description,
            'can_have'            => $can_have,
            ]),
            'new_chapter_types'
        );

        \App\Models\Type::create([
          'chapter_type'        => $type,
          'chapter_description' => $description,
          'can_have'            => $can_have,
        ]);
    }
}
