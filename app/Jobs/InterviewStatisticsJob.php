<?php

namespace App\Jobs;

use App\Mail\StatisticsGenerated;
use App\Notifications\StatisticsGeneratedNotification;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\StatisticsService\StatisticsInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class InterviewStatisticsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $statistics_service;
    protected $user_repository;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(StatisticsInterface $statistics_service, UserRepositoryInterface $user_repository)
    {
        $this->statistics_service = $statistics_service;
        $this->user_repository = $user_repository;
        Notification::send($this->user_repository->me(),
            new StatisticsGeneratedNotification($this->statistics_service->getStatistics()));
    }
}