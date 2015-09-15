<?php

class TypeSeeder extends Seeder {

    public function run()
    {
        // Chapter types

        DB::collection( 'types' )->delete();

        $this->createChapter('district', 'Naval District', [ 'fleet']);
        $this->createChapter('fleet', 'Fleet', ['ship', 'division', 'squadron', 'task_group', 'task_force']);
        $this->createChapter('task_force', 'Task Force', ['task_group', 'squadron', 'division', 'ship']);
        $this->createChapter('task_group', 'Task Group', ['squadron', 'division', 'ship']);
        $this->createChapter('squadron', 'Squadron of Ships', ['ship', 'division']);
        $this->createChapter('division', 'Division of Ships', [ 'ship']);
        $this->createChapter('ship', 'Naval Ship', ['mardet']);
        $this->createChapter('mardet', 'Marine Detachment');
        $this->createChapter('station', 'Space Station');
        $this->createChapter('headquarters', 'Headquarters Chapter');
        $this->createChapter('bivouac', 'Army Bivouac');
        $this->createChapter('barracks', 'Army Barracks');
        $this->createChapter('outpost', 'Army Outpost');
        $this->createChapter('fort', 'Army Fort');
        $this->createChapter('planetary', 'Army Planetary Command');
        $this->createChapter('theater', 'Army Theater Command');
        $this->createChapter('bureau', 'Admiralty Bureau');
        $this->createChapter('academy', 'Service Academy');
    }

    function createChapter($type, $description, array $can_have=[]) {
        $this->command->comment('Creating ' . $description . ' type');
        Type::create( [ 'chapter_type' => $type, 'chapter_description' => $description, 'can_have' => $can_have]);
    }
}
