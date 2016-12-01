<?php
namespace Medusa\Services;

use Illuminate\Support\ServiceProvider;
use Medusa\Validators\MedusaValidators;

class MedusaServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app->validator->resolver(
            function ($translator, $data, $rules, $messages = array(), $customAttributes = array()) {
                return new MedusaValidators($translator, $data, $rules, $messages, $customAttributes);
            }
        );
    }
}
