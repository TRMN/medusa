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
        \App\Console\Commands\CodeTest::class,
        \App\Console\Commands\CreateEchelons::class,
        \App\Console\Commands\ImportGrades::class,
        \App\Console\Commands\AddPermission::class,
        \App\Console\Commands\ViewsCommand::class,
        \App\Console\Commands\ImportChapters::class,
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\ChangePassword::class,
        \App\Console\Commands\DelPermission::class,
        \App\Console\Commands\MemberExport::class,
        \App\Console\Commands\ImportUsers::class,
        \App\Console\Commands\assignAHPerms::class,
        \App\Console\Commands\AddFleetCoPermission::class,
        \Themsaid\RoutesPublisher\RoutesPublisherCommand::class
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
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
