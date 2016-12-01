<?php

namespace App\Libraries;

use Illuminate\Support\ServiceProvider;


class MedusaHasherServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'hash',
            function () {
                return new MedusaHasher;
            }
        );
    }
}
