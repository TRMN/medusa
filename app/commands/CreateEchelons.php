<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateEchelons extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'create:echelons';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create the current TRMN echelons';

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
        // 10th Fleet Echelons
        $this->createEchelon('Battlecruiser Division 962', 'division', '2015-01-20', 'BatCruDiv 962', 'RMN', 'RMN-1017-12', ['HMS Helen', 'HMS Black Rose', 'HMS Earsidh Kamerling']);
        $this->createEchelon('Battlecruiser Division 961', 'division', '2015-01-20', 'BatCruDiv 961', 'RMN', 'RMN-0485-11', ['HMS Truculent', 'HMS Andromeda', 'HMS Callisto']);
        $this->createEchelon('Battlecruiser Squadron 96', 'squadron', '2015-01-20', 'BatCruRon 96', 'RMN', 'RMN-1908-14', ['Battlecruiser Division 961', 'Battlecruiser Division 962'], '10');
        $this->createEchelon('Task Group 91.1', 'task_group', '2014-06-17', 'TG 91.1', 'RMN', 'RMN-0397-11', ['HMS Cerberus', 'HMS Artemis', 'HMS Merlin', 'HMS Wolf', 'HMS Roland'], '10');

        // 8th Fleet Echelons
        $this->createEchelon('Battlecruiser Division 865', 'division', '2015-08-24', 'BatCruDiv 865', 'RMN', 'RMN-1311-13', ['HMS Enterprise', 'HMS Reliant'], '8');

        // 6th Fleet Echelons
        $this->createEchelon('Carrier (LAC) Division 611', 'division', '2015-04-14', 'ClacDiv 611', 'RMN', 'RMN-2346-14', ['HMS Pegasus', 'HMS Hydra', 'HMS Bravery'], '6');

        // 4th Fleet Echelons
        $this->createEchelon('Destroyer Division 413', 'division', '2015-04-16', 'DesDiv 413', 'GSN', 'RMN-0069-10', ['GNS Mercy', 'GNS Joshua', 'GNS Albion'], '4');

        // 3rd Fleet Echelons
        $this->createEchelon('Battlecruiser Division 311', 'division', '2012-04-14', 'BatCruDiv 311', 'RMN', 'RMN-0892-12', ['HMS Agamemnon', 'HMS Beowulf', 'HMS Wolfhound'], '3');
        $this->createEchelon('Carrier (LAC) Division 624', 'division', '2015-08-16', 'ClacDiv 624', 'RMN', 'RMN-1874-14', ['HMS Specter', 'HMS Salamander', 'HMS Devastation'], '3');
        $this->createEchelon('Battlecruiser Division 314', 'division', '2015-08-09', 'BatCruDiv 314', 'RMN', 'RMN-1138-12', ['HMS Excalibur', 'HMS Achilles', 'HMS Ancile'], '3');

        // 2nd Fleet Echelons
        $this->createEchelon('Cruiser Division 711', 'division', '2015-08-25', 'CruDiv 711', 'RMN', 'RMN-0542-12', ['HMS Hexapuma', 'HMS Sabrepike'], '2');
        $this->createEchelon('Cruiser (Light) Division 651', 'division', '2015-08-25', 'LCruDiv 651', 'RMN', 'RMN-2374-14', ['HMS Gallant', 'HMS Odin', 'HMS Apollo'], '2');
        $this->createEchelon('Battle Squadron 1', 'squadron', '2014-11-03', 'BatRon 1', 'RMN', 'RMN-0366-11', ['HMS Invincible', 'HMS Valkyrie', 'HMS Intrepid', 'HMS Imperatrix']);
        $this->createEchelon('Task Group 21.2', 'task_group', '2014-11-03', 'TG 21.2', 'RMN', 'RMN-0384-11',['HMS Musashi', 'HMS Kodiak Max', 'HMS Gawain', 'HMS Galahad']);
        $this->createEchelon('Task Group 21.1', 'task_group', '2014-11-03', 'TG 21.1', 'RMN', 'RMN-0366-11', ['Battle Squadron 1','HMS Leonidas', 'HMS Samurai', 'HMS Lodestone', 'HMLAC Superior', 'Pinnace Invincible 01', 'Pinnace Intrepid 01', 'Pinnace Valkyrie 01']);
        $this->createEchelon('Task Force 21', 'task_force', '2014-11-03', 'TF 21', 'RMN', 'RMN-0117-11', ['Task Group 21.1', 'Task Group 21.2'], '2');

        // 1st Fleet Echelons
        $this->createEchelon('BattleCruiser Division 111', 'division', '2014-04-02', 'BatCruDiv 111', 'RMN', 'RMN-1512-13', ['HMS Rigel', 'HMS Heracles'], '1');
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

    protected function assignChaptersToEchelon($echelon, array $ships)
    {
        // Iterate over the array of ship names
        foreach ($ships as $ship) {
            $this->info(' Looking up ' . $ship);
            // Get ship info
            $shipInfo = Chapter::where('chapter_name', '=', $ship)->First();

            // Update the assigned to field
            $shipInfo->assigned_to = $echelon;

            // Save it
            $shipInfo->save();
            $this->info(' Assigned ' . $ship . ' to echelon');
        }

        return true;
    }

    protected function assignEchelonCO($echelon, $name, $trmnID)
    {
        // Get the CO
        $member = User::where('member_id','=', $trmnID)->First();

        // Get the CO's current assignments
        $assignments = $member->assignment;

        // Make sure that we don't create a duplicate assignment

        $makeCO = true;

        foreach($assignments as $assignment){
            if ($assignment['chapter_id'] === $echelon) {
                $makeCO = false;
            }
        }

        if ($makeCO === true) {
            // Build the new assignment
            $assignments[] = [
                'chapter_id'   => $echelon,
                'billet'       => 'Commanding Officer',
                'Chapter Name' => $name,
            ];

            // Update the members record
            $member->assignment = $assignments;

            $member->save();
        }
        $this->info(' CO for ' . $name . ' set');
        return true;
    }

    protected function createEchelon($name, $type, $cdate, $designation, $branch, $co, array $elements, $fleet = null)
    {
        $this->info('Creating echelon ' . $name);
        // Build the echelon record
        $echelonRecord = [
            'chapter_name' => $name,
            'chapter_type' => $type,
            'commission_date' => $cdate,
            'hull_number' => $designation,
            'branch' => $branch,
            'joinable' => false,
        ];

        // Assign this echelon directly to a fleet
        if (is_null($fleet) === false) {
            $fleet = Chapter::where('chapter_type', '=', 'fleet')->where('hull_number','=',$fleet)->First();
            $echelonRecord['assigned_to'] = (string)$fleet->_id;
        }

        // Create the echelon unless it already exists
        if (count(Chapter::where('hull_number', '=', $designation)->get()) === 0) {
            $echelon = Chapter::create($echelonRecord);
        } else {
            $echelon = Chapter::where('hull_number', '=', $designation)->First();
        }

        // Assign the CO of the echelon
        $this->assignEchelonCO((string)$echelon->_id, $name, $co);

        // Assign the elements to the echelon
        $this->assignChaptersToEchelon((string)$echelon->_id, $elements);


        return true;
    }

}
