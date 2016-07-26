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
        $ship = Chapter::find('55fa1833e4bed832078b45dc');

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setNewline("\r\n");
        $crew = $ship->getAllCrew();

        $headers =
            [
                'RMN Number',
                'First Name',
                'Middle Name',
                'Last Name',
                'Suffix',
                'Email Address',
                'Phone Number',
                'Address 1',
                'Address 2',
                'City',
                'State/Province',
                'Postal Code',
                'Country',
                'Rank',
                'Date of Rank'
            ];

        $csv->insertOne($headers);

        foreach ($crew as $member) {
            $csv->insertOne(
                [
                    $member->member_id,
                    $member->first_name,
                    $member->middle_name,
                    $member->last_name,
                    $member->suffix,
                    $member->email_address,
                    $member->phone_number,
                    $member->address1,
                    $member->address2,
                    $member->city,
                    $member->state_province,
                    $member->postal_code,
                    $member->country,
                    $member->rank['grade'],
                    $member->rank['date_of_rank']
                ]
            );
        }

        $csv->output(date('Y-m-d') . '_' . str_replace(' ', '_', $ship->chapter_name) . '_roster.csv');
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