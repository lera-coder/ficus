<?php

namespace App\Providers;

use App\Services\Filtration\InterviewFiltrationService\InterviewFiltration;
use App\Services\Filtration\InterviewFiltrationService\InterviewFiltrationInterface;
use Illuminate\Support\ServiceProvider;

class FiltrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InterviewFiltrationInterface::class, InterviewFiltration::class);
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
