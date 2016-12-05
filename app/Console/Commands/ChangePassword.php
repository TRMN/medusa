<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;



class ChangePassword extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:addperm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a permission to a user';

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
        $user = User::where('member_id', '=', $this->argument('member_id'))->first();

        $user->updatePerms([strtoupper($this->argument('perm'))]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [ 'member_id', InputArgument::REQUIRED, 'The user\'s TRMN number' ],
            [ 'passwd', InputArgument::REQUIRED, 'The permission to add' ],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [ ];
    }
}
