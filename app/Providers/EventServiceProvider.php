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
        'App\Events\LoginComplete' => [
            'App\Listeners\QE3CM',
            'App\Listeners\KR3CM',
            'App\Listeners\QE3SJM',
            'App\Listeners\QE3GJM',
            'App\Listeners\SWP',
            'App\Listeners\MCAM',
        ],
        'App\Events\EmailChanged' => [
            'App\Listeners\UpdateForumEmail',
        ],
        'App\Events\GradeEntered' => [
            'App\Listeners\SWP',
            'App\Listeners\MCAM',
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