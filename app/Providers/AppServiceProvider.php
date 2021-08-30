<?php

namespace App\Providers;

use App\Extensions\PasswordBrokerManagerCustom;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManagerCustom($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
