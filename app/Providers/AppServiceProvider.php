<?php

namespace App\Providers;

use App\Auth\UserProvider;
use Illuminate\Support\ServiceProvider;
use Code\Validator\Cpf;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('cpf', function($attribute, $value, $parameters, $validator){
            return (new Cpf())->isValid($value);
        });
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
