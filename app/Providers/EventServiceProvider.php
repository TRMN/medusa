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
        \App\Models\Events\LoginComplete::class => [
            \App\Listeners\QE3CM::class,
            \App\Listeners\KR3CM::class,
            \App\Listeners\QE3SJM::class,
            \App\Listeners\QE3GJM::class,
            \App\Listeners\SWP::class,
            \App\Listeners\MCAM::class,
        ],
        \App\Models\Events\EmailChanged::class => [
            \App\Listeners\UpdateForumEmail::class,
        ],
        \App\Models\Events\GradeEntered::class => [
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
