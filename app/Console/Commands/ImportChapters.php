<?php

namespace App\Console\Commands;

use App\Chapter;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportChapters extends Command
{
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

    use \App\Audit\MedusaAudit;

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
    public function handle()
    {
        // Need to know about the fleets

        $results = Chapter::where('chapter_type', '=', 'fleet')->get();

        // Make a lookup table that's easier to use, indexed by the fleet number

        $fleets = [];

        foreach ($results as $fleet) {
            $fleets[$fleet['hull_number']] = ['chapter_name' => $fleet['chapter_name'], '_id' => $fleet['_id']];
        }

        // Open the Master Berthing Registry.  Only import sheets with values

        $trmn = [
            'RMN' => Excel::selectSheets('RMN Ships')->load(app_path().'/database/berthing_registry.xlsx')
                ->formatDates(true, 'Y-m-d')
                ->toArray(),
            'GSN' => Excel::selectSheets('GSN Ships')->load(app_path().'/database/berthing_registry.xlsx')
                ->formatDates(true, 'Y-m-d')
                ->toArray(),
            'IAN' => Excel::selectSheets('IAN Ships')->load(app_path().'/database/berthing_registry.xlsx')
                ->formatDates(true, 'Y-m-d')
                ->toArray(),
        ];

        $decomissioned =
            Excel::selectSheets('Decommissioned Ships')
                ->load(app_path().'/database/berthing_registry.xlsx')
                ->formatDates(true, 'Y-m-d')
                ->toArray();

        foreach ($trmn as $branch => $ships) {
            if (count($ships) !== 0) {
                foreach ($ships as $ship) {
                    if (empty($ship['name']) === true) {
                        continue;
                    }

                    // Make sure that the ship doesn't already exist
                    if (count(Chapter::where('chapter_name', '=', $ship['name'])->get()->toArray()) === 0) {
                        $this->comment(
                            'Creating '.$ship['name'].', assigned to '.$fleets[$ship['fleet']]['chapter_name']
                        );
                        $this->writeAuditTrail('import', 'create', 'chapters', null, json_encode(
                            [
                                'branch' => $branch,
                                'chapter_name' => $ship['name'],
                                'chapter_type' => 'ship',
                                'hull_number' => $ship['hull_number'],
                                'ship_class' => $ship['class'],
                                'commission_date' => $ship['commissioned'],
                                'assigned_to' => $fleets[$ship['fleet']]['_id'],
                            ]
                        ), 'import.chapters');

                        $result = Chapter::create(
                            [
                                'branch' => $branch,
                                'chapter_name' => $ship['name'],
                                'chapter_type' => 'ship',
                                'hull_number' => $ship['hull_number'],
                                'ship_class' => $ship['class'],
                                'commission_date' => $ship['commissioned'],
                                'assigned_to' => $fleets[$ship['fleet']]['_id'],
                            ]
                        );

                        // For some reason, mongo drops the branch field, so let's update the document after the initial save

                        $chapter = Chapter::find($result['_id']);
                        $chapter['branch'] = $branch;
                        $chapter->save();
                    } else {
                        $this->comment($ship['name'].' already exists, skipping');
                    }
                }
            }
        }

        // Process the decomissioned ships

        $this->comment('Adding Decommissioned Ships');

        foreach ($decomissioned as $ship) {
            if (empty($ship['name']) === true) {
                continue;
            }
            // Make sure that the ship doesn't already exist
            if (count(Chapter::where('chapter_name', '=', $ship['name'])->get()->toArray()) === 0) {
                $this->comment(
                    'Creating '.$ship['name'].', assigned to '.$fleets[$ship['fleet']]['chapter_name']
                );

                $this->writeAuditTrail(
                    'import',
                    'create',
                    'chapters',
                    null,
                    json_encode(
                        [
                            'branch' => $ship['branch'],
                            'chapter_name' => $ship['name'],
                            'chapter_type' => 'ship',
                            'hull_number' => $ship['hull_number'],
                            'decommission_date' => $ship['decommissioned'],
                            'assigned_to' => $fleets[$ship['fleet']]['_id'],
                        ]
                    ),
                    'import.chapters'
                );

                $result = Chapter::create(
                    [
                        'branch' => $ship['branch'],
                        'chapter_name' => $ship['name'],
                        'chapter_type' => 'ship',
                        'hull_number' => $ship['hull_number'],
                        'decommission_date' => $ship['decommissioned'],
                        'assigned_to' => $fleets[$ship['fleet']]['_id'],
                    ]
                );

                // For some reason, mongo drops the branch field, so let's update the document after the initial save

                $chapter = Chapter::find($result['_id']);
                $chapter['branch'] = $ship['branch'];
                $chapter->save();
            } else {
                $this->comment($ship['name'].' already exists, skipping');
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
}
