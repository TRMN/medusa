<?php

namespace App\Console;

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
        \App\Console\Commands\ImportChapters::class,
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\DelPermission::class,
        \App\Console\Commands\MemberExport::class,
        \App\Console\Commands\ImportUsers::class,
        \App\Console\Commands\assignAHPerms::class,
        \App\Console\Commands\AddFleetCoPermission::class,
        \App\Console\Commands\UpdatePromotionStatus::class,
        \App\Console\Commands\SwpReport::class,
        \App\Console\Commands\SWPCheck::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('member:updps')->dailyAt('02:00');
        $schedule->command('report:swp')->monthlyOn();
        $schedule->command('user:swpCheck')->monthlyOn(5);
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
