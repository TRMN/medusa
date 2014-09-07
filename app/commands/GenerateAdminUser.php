<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateAdminUser extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'users:createadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an administrator user.';

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
        $password = $this->argument( 'password' );
        $username = $this->argument( 'username' );
        $email = $this->argument( 'email' );
        $zipcode = $this->argument( 'zipcode' );

        try {
            $user = new User();
            $user->password = Hash::make( $password );
            $user->email = $email;
            $user->zipcode = $zipcode;
            $user->name = $username;
            $user->save();
            $this->info( 'User created successfully.' );
        } catch ( Exception $e ) {
            $this->error( $e );
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [ 'username', InputArgument::REQUIRED, 'The username.' ],
            [ 'email', InputArgument::REQUIRED, 'User email.' ],
            [ 'password', InputArgument::REQUIRED, 'User password.' ],
            [ 'zipcode', InputArgument::REQUIRED, 'User zipcode.' ]
        ];
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
