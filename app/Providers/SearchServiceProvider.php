<?php

namespace App\Providers;

use App\Services\SearchService\AllSearchService\AllMySqlSearchService;
use App\Services\SearchService\AllSearchService\AllSearchServiceInterface;
use App\Services\SearchService\ProjectSearchService\ProjectMySqlSearchService;
use App\Services\SearchService\ProjectSearchService\ProjectSearchServiceInterface;
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
        $this->app->bind(ProjectSearchServiceInterface::class, ProjectMySqlSearchService::class);
        $this->app->bind(AllSearchServiceInterface::class, AllMySqlSearchService::class);
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
