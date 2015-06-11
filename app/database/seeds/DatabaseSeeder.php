<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('CountriesSeeder');
        $this->call('ChapterSeeder');
        $this->call('RatingSeeder');
        $this->call('GradeSeeder');
        $this->call('BranchSeeder');
        $this->call('TigSeeder');
        $this->call('TypeSeeder');
        $this->call('UserSeeder');
    }

}
