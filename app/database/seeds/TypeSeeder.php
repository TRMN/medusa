<?php

class TypeSeeder extends Seeder {

    public function run()
    {
        // Chapter types

        DB::collection( 'types' )->delete();

        Type::create( [ 'chapter_type' => 'district', 'chapter_description' => 'Naval District', 'can_have' => [ 'fleet' ] ] );
        Type::create( [ 'chapter_type' => 'fleet', 'chapter_description' => 'RMN Fleet', 'can_have' => [ 'ship', 'division', 'squadron', 'task group', 'task force' ] ] );
        Type::create( [ 'chapter_type' => 'squadron', 'chapter_description' => 'Squadron of Ships', 'can_have' => [ 'ship', 'division' ] ] );
        Type::create( [ 'chapter_type' => 'division', 'chapter_description' => 'Division of Ships', 'can_have' => [ 'ship' ] ] );
        Type::create( [ 'chapter_type' => 'ship', 'chapter_description' => 'Naval Ship', 'can_have' => [ 'mardet', 'ship' ] ] );
        Type::create( [ 'chapter_type' => 'mardet', 'chapter_description' => 'Marine Detachment', 'can_have' => [ ] ] );
    }
} 
