<?php

namespace App\Services;

use App\MedusaHasher;
use Illuminate\Support\ServiceProvider;

class MedusaHasherServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('hash')->extend('sha1', function () {
            return new MedusaHasher();
        });
    }
}
