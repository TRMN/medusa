<?php

namespace App\Console\Commands;

use App\AwardLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class McamReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:mcam {date? : Month to run the report for in the format YYYY-MM}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and email MCAM report';

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

        $endOfMonth = Carbon::parse($reportDate)->endOfMonth()->format('Y-m-d');

        $mcam['report_date'] = date('F, Y', strtotime($reportDate));
        $mcam['MCAM'] = AwardLog::getAwardLogData(['award' => 'MCAM', 'start' => $reportDate, 'end' => $endOfMonth]);

        \Mail::to(config('awards.SWP-notification.email'))->send(new \App\Mail\mcamReport($mcam));
    }
}