<?php

namespace App\Console\Commands;

use App\Award;
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

        foreach (\App\User::activeUsers() as $user) {
            // Check for SWP qualification.  This is for existing SWP's that may
            // not be recorded, so set isNewAward to false.  Check for SWP first,
            // because you can get a MCAM unless you have a SWP
            $user->swpQual(false);

            // Check for 1 or more MCAM's.  Again, this is for existing MCAM's
            // that may not be recorded, so set isNewAward to false.
            $user->mcamQual(false);
        }
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
