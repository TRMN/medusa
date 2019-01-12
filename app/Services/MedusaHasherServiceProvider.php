<?php

namespace App\Services;

use App\MedusaHasher;
use Illuminate\Support\ServiceProvider;

class MedusaHasherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'hash',
            function () {
                return new MedusaHasher();
            }
        );
    }
}
