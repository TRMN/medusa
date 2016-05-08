<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CodeTest extends Command
{
    use \Medusa\Permissions\MedusaPermissions;

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
        $exams = Exam::where('member_id', '=', 'RMN-1094-12')->first()->exams['KR1MA-RMAT-18B']['entered_by'];

        print_r($exams);

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