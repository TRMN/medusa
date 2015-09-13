<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class assignAHPerms extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:AHperms';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Assign permissions to Admiralty House';

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
        // Martin Lessem, Scott Akers, Steph Taylor, Dave Weiner
        foreach(['RMN-0001-07', 'RMN-0011-08', 'RMN-0147-11', 'RMN-1094-12'] as $member) {
            $rec = $this->_getMember($member);
            $rec->assignAllPerms();
            $this->info('Assigned All Permissions to ' . $rec->first_name . ' ' . $rec->last_name);
        }

        // John Roberts
        $rec = $this->_getMember('RMN-0052-10');
        $rec->assignBuShipPerms();
        $rec->assignSpaceLordPerms();
        $this->info('Assigned BuShip and Space Lord permissions to John Roberts');

        // Drew Drentlaw, Jame Friedline, Brandi Hinson, Bob Bulkeley
        foreach(['RMN-0903-12', 'RMN-0119-11', 'RMN-0151-11', 'RMN-0055-10'] as $member) {
            $rec = $this->_getMember($member);
            $rec->assignSpaceLordPerms();
            $this->info('Assigned Space Lord permissions to ' . $rec->first_name . ' ' . $rec->last_name);
        }
	}

    private function _getMember($rmnId) {
        return User::where('member_id','=', $rmnId)->First();
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
