<?php

namespace App\Providers;

use App\Services\ModelService\EmailService\EmailService;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use App\Services\ModelService\UserService\UserService;
use App\Services\ModelService\UserService\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
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
