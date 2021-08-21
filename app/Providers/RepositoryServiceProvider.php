<?php

namespace App\Providers;

use App\Repositories\EmailRepository;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\UserRepositoryInterface',
        'App\Repositories\UserRepository');

        $this->app->bind(EmailRepositoryInterface::class,
        EmailRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
