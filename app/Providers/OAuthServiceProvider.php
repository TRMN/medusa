<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OAuthService;

class OAuthServiceProvider extends ServiceProvider
{
    /** @inheritdoc */
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
