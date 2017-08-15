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

        $awards = ["AFSM", "NCOSCR", "RTR", "NPMC", "NRMC", "NPS", "NRS", "NPE", "NRE", "NPHE", "NRHE", "SSD", "GCM", "MRSM", "MtSM", "MCAM", "QE3GJM", "QE3SJM", "QE3CM", "KR3CM", "GACM", "MHW", "HOSM", "HWC", "MOM", "SAPC", "SvC", "POW", "FEA", "RMUC", "RUCG", "LOH", "NMAM", "NCD", "MSM", "CSM", "CBM", "EM", "GLM", "RM", "MID", "RHDSM", "QBM", "WS", "OCN", "GS", "CGM", "MT", "ME", "MGL", "MR", "DSO", "NS", "OG", "OE", "OGL", "OR", "DGC", "SC", "CE", "CGL", "CR", "KE", "KGL", "KR", "OC", "MC", "KCE", "KCGL", "KCR", "KDE", "KDGL", "KDR", "OM", "GCE", "GCGL", "GCR", "KSK", "AC", "QCB", "PMV"];

//        foreach ($awards as $award) {
//            try {
//                Award::where('code', $award)->firstOrFail();
//            } catch (\Exception $e) {
//                $this->info('Could not find ' . $award);
//            }
//        }

        $awards = Award::all();

        $awards = array_sort($awards->toArray(), function ($value) {
            return $value['display_order'];
        });

        foreach ($awards as $award) {
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
