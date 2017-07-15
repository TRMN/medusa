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
        $awards = Award::all();

        $awards = array_sort($awards->toArray(), function($value) {
            return $value['display_order'];
        });

        foreach($awards as $award) {
            print $award['display_order'] . ' ' . $award['name'] . ' (' . $award['code'] . ")\n";
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
