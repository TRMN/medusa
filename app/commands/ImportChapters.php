<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportChapters extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import:chapters';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import chapters from the old system';

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
        // Need to know about the fleets

		$results = Chapter::where( 'chapter_type', '=', 'fleet')->get();

        // Make a lookup table that's easier to use, indexed by the fleet number

        $fleets = [];

        foreach ($results as $fleet) {
            $fleets[$fleet['hull_number']] = [ 'chapter_name' => $fleet['chapter_name'], '_id' => $fleet['_id']];
        }

        // Open the Master Berthing Registry

        $registry = Excel::load( app_path() . '/database/berthing_registry.xls' )->formatDates( true, 'Y-m-d' )->toArray();
print_r($registry);
        $trmn = ['RMN' => $registry[0], 'GSN' => $registry[1], 'IAN' => $registry[2], 'RHN' => $registry[3]];

        foreach ( $trmn as $branch => $ships )
        {
            if ( count( $ships ) !== 0 )
            {
                foreach ( $ships as $ship )
                {
                    $this->comment("Creating " . $ship['name'] . ", assigned to " . $fleets[$ship['fleet']]['chapter_name']);
                    Chapter::create(
                        [
                            'chapter_name'    => $ship['name'],
                            'chapter_type'    => 'ship',
                            'hull_number'     => $ship['hull_number'],
                            'ship_class'      => $ship['class'],
                            'commission_date' => $ship['commissioned'],
                            'assigned_to'     => $fleets[$ship['fleet']]['_id']
                        ]
                    );
                }
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
		return [ ];
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
