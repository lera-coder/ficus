<?php

namespace App\Providers;

use App\Http\Controllers\API\InterviewController;
use App\Jobs\InterviewStatisticsJob;
use App\Models\Interview;
use App\Services\StatisticsService\InterviewStatics\InterviewStatistics;
use App\Services\StatisticsService\StatisticsInterface;
use Illuminate\Support\ServiceProvider;

class StatisticsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StatisticsInterface::class, InterviewStatistics::class);
//        $this->app->when(InterviewStatisticsJob::class)
//            ->needs(StatisticsInterface::class)
//            ->give(function (){
//                return InterviewStatistics::class;
//            });
//        $this->app->when(InterviewController::class)
//            ->needs(StatisticsInterface::class)
//            ->give(function (){
//                return InterviewStatistics::class;
//            });
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
