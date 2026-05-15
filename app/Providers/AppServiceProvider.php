<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::withoutDoubleEncoding();
        Paginator::useBootstrapThree();

        $previousHandler = set_error_handler(function ($level, $message, $file = '', $line = 0) use (&$previousHandler) {
            if (in_array($level, [E_DEPRECATED, E_USER_DEPRECATED])) {
                Log::warning("Deprecation: $message in $file on line $line");
                return true; 
            }

            if ($previousHandler) {
                return $previousHandler($level, $message, $file, $line);
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
    }
}
