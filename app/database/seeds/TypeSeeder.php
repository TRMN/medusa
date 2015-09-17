<?php

class TypeSeeder extends Seeder
{
    use \Medusa\Audit\MedusaAudit;

    public function run()
    {
        // Chapter types

        DB::collection( 'types' )->delete();

        $this->createChapterType('district', 'Naval District', [ 'fleet']);
        $this->createChapterType('fleet', 'Fleet', ['ship', 'division', 'squadron', 'task_group', 'task_force']);
        $this->createChapterType('task_force', 'Task Force', ['task_group', 'squadron', 'division', 'ship']);
        $this->createChapterType('task_group', 'Task Group', ['squadron', 'division', 'ship']);
        $this->createChapterType('squadron', 'Squadron of Ships', ['ship', 'division']);
        $this->createChapterType('division', 'Division of Ships', [ 'ship']);
        $this->createChapterType('ship', 'Naval Ship', ['mardet']);
        $this->createChapterType('mardet', 'Marine Detachment');
        $this->createChapterType('station', 'Space Station');
        $this->createChapterType('headquarters', 'Headquarters Chapter');
        $this->createChapterType('bivouac', 'Army Bivouac');
        $this->createChapterType('barracks', 'Army Barracks');
        $this->createChapterType('outpost', 'Army Outpost');
        $this->createChapterType('fort', 'Army Fort');
        $this->createChapterType('planetary', 'Army Planetary Command');
        $this->createChapterType('theater', 'Army Theater Command');
        $this->createChapterType('bureau', 'Admiralty Bureau');
        $this->createChapterType('academy', 'Service Academy');
    }

    function createChapterType($type, $description, array $can_have=[]) {
        $this->command->comment('Creating ' . $description . ' type');

        $this->writeAuditTrail(
            'db:seed',
            'create',
            'types',
            null,
            json_encode(['chapter_type' => $type, 'chapter_description' => $description, 'can_have' => $can_have]),
            'type'
        );

        Type::create( [ 'chapter_type' => $type, 'chapter_description' => $description, 'can_have' => $can_have]);
    }
}
