<?php

namespace App\Console\Commands;

use App\AwardLog;
use Illuminate\Console\Command;

class SwpReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:swp {date? : Month to run the report for in the format YYYY-MM}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and email SWP report';

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
        $reportDate = $this->argument('date');

        if (is_null($reportDate) === true) {
            $reportDate = date('Y-m-01');
        }

        $swp['report_date'] = date('F, Y', strtotime($reportDate));
        $swp['ESWP'] = AwardLog::getAwardLogData(['award' => 'ESWP', 'start' => $reportDate]);
        $swp['OSWP'] = AwardLog::getAwardLogData(['award' => 'OSWP', 'start' => $reportDate]);

        \Mail::to('david.l.weiner30030@gmail.com')->send(new \App\Mail\swpReport($swp));
    }
}
