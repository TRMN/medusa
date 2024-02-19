<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\LoginComplete::class => [
            \App\Listeners\QE3CM::class,
            \App\Listeners\KR3CM::class,
            \App\Listeners\QE3SJM::class,
            \App\Listeners\QE3GJM::class,
            \App\Listeners\SWP::class,
            \App\Listeners\MCAM::class,
            \App\Listeners\YSMR::class,
            \App\Listeners\QE3DJM::class,
        ],
        \App\Events\EmailChanged::class => [
            \App\Listeners\UpdateForumEmail::class,
        ],
        \App\Events\GradeEntered::class => [
            \App\Listeners\SWP::class,
            \App\Listeners\MCAM::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
