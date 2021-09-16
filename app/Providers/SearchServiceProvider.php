<?php

namespace App\Providers;

use App\Services\SearchService\UserSearchService\UserMySqlService;
use App\Services\SearchService\UserSearchService\UserSearchServiceInterface;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserSearchServiceInterface::class, UserMySqlService::class);
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
