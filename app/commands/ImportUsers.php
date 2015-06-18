<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportUsers extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from the old system';

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
        // Get the list of countries
        $results = Countries::getList();
        $countries = [];

        foreach ( $results as $country )
        {
            $countries[$country['name']] = $country['iso_3166_3'];
        }

        // Get the users

        $users = Excel::load( app_path() . '/database/users.xlsx' )->formatDates( true, 'Y-m-d' )->toArray();

        foreach ( $users as $user )
        {
            $user['rank']['grade'] = $user['grade'];
            $user['rank']['date_of_rank'] = '';
            unset( $user['grade'] );

            $user['assignment'][] =
                ['chapter_id' => $this->getChapterByName( $user['ship_name'] )[0]['_id'], 'billet' => $user['primary_billet'], 'primary' => true, 'chapter_name' => $user['ship_name']];
            unset( $user['ship_name'] );
            unset( $user['primary_billet'] );

            if ( $user['secondary_billet'] !== 'NULL' )
            {
                $user['assignment'][] = ['chapter_id' => '', 'billet' => $user['secondary_billet'], 'primary' => false];
            }

            unset( $user['secondary_billet'] );

            if ( $user['registration_date'] === 'NULL' )
            {
                $user['registration_date'] = $user['application_date'];
            }

            if ( $user['application_date'] === 'NULL' )
            {
                $user['application_date'] = $user['registration_date'];
            }

            if (isset($user['country'])) {
                $user['country'] = $countries[$user['country']];
            } else {
                $user['country'] = 'USA';
            }

            $user['awards'] = [];

            foreach ( $user as $key => $value )
            {
                if ( is_null( $value ) === true || $value === 'NULL' )
                {
                    unset( $user[$key] );
                }
            }

            if (isset($user['postal_code']) === true && empty($user['postal_code'])===false) {
                $user['postal_code'] = (string)$user['postal_code'];
            } else {
                $user['postal_code'] = '';
            }



            // Make sure this is not a duplicate user
            if (count(User::where('member_id', '=', $user['member_id'])->get()) === 0) {
                $result = User::create( $user );

                $u = User::find($result['_id']);

                foreach ($user as $key => $value) {
                    $u[$key] = $value;
                }

                $u->save();
            } else {
                $this->error("Duplicate user found! " . $user['member_id'] . " already exists in the database!");
            }
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

    protected function getChapterByName( $name )
    {

        $results = Chapter::where( 'chapter_name', '=', $name )->get();
        if (count($results) > 0) {
            return $results;
        } else {
            $this->info("Chapter " . $name . " not found, creating...");
            Chapter::create( ['chapter_name' => $name, 'chapter_type' => ''] );
            return Chapter::where( 'chapter_name', '=', $name )->get();
        }
    }

}
