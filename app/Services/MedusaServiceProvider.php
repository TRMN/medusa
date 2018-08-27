<?php

namespace App\Services;

use App\Validators\MedusaValidators;
use Illuminate\Support\ServiceProvider;

class MedusaServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app->validator->resolver(
            function ($translator, $data, $rules, $messages = [], $customAttributes = []) {
                return new MedusaValidators($translator, $data, $rules, $messages, $customAttributes);
            }
        );
    }
}
