<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SWPCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:swpCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for orphaned and/or missing ESWP to OSWP conversions';

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
     * @throws \Exception
     */
    public function handle()
    {
        /** @var \App\User $user */
        $count = 0;
        foreach (\App\User::activeUsers() as $user) {
            // Check for SWP qualification.  This is for existing SWP's that may
            // not be recorded, so set isNewAward to false.  Check for SWP first,
            // because you can get a MCAM unless you have a SWP
            try {
                if ($user->swpQual(false)) {
                    $this->info("Adding SWP to " . $user->getFullName());
                    $count++;
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }
        $this->info("Total SWP's added: " . $count);
    }
}
