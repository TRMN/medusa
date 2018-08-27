<?php

namespace App\Providers;

use App\Passport\Client;
use Illuminate\Support\ServiceProvider;

class PassportServiceProvider extends ServiceProvider
{
    public function register()
    {
        /*
         * Passport client extends Eloquent model by default, so we alias them.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('Laravel\Passport\Client', Client::class);
    }
}
