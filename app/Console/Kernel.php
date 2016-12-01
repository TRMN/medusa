<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\CodeTest',
        'App\Console\Commands\CreateEchelons',
        'App\Console\Commands\ImportGrades',
        'App\Console\Commands\AddPermission',
        'App\Console\Commands\ViewsCommand',
        'App\Console\Commands\ImportChapters',
        'App\Console\Commands\Inspire',
        'App\Console\Commands\ChangePassword',
        'App\Console\Commands\DelPermission',
        'App\Console\Commands\MemberExport',
        'App\Console\Commands\ImportUsers',
        'App\Console\Commands\assignAHPerms',
        'App\Console\Commands\AddFleetCoPermission',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
