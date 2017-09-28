<?php

namespace App\Providers;

use App\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Auth::provider('custom_auth', function($app, array $config) {
            return new UserProvider($app['hash'], $config['model']);
        });
    }
}
