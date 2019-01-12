<?php

namespace App\Providers;

use App\Services\OAuthService;
use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    /** {@inheritdoc} */
    public function register()
    {
        $this->app->singleton(
            'oauth2',
            function ($app) {
                return new OAuthService($app);
            }
        );
    }
}
