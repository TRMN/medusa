<?php

class AuditSeeder extends Seeder
{

    public function run()
    {
        DB::collection('audit_trail')->delete();
    }
}
