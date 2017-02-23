<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CodeTest extends Command
{
    use \App\Permissions\MedusaPermissions;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'code:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test random parts of the code base';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        print_r(\App\Award::getTopBadges(['SAW','EAW','OAW','ESAW','OSAW','EMAW','OMAW','ENW','ONW','ESNW','OSNW','EMNW','OMNW','EOW','OOW','ESOW','OSOW','EMOW','OMOW','ESW','OSW','ESSW','OSSW','EMSW','OMSW']));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
