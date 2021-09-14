<?php


namespace App\Services\StatisticsService\InterviewStatics;


use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Services\StatisticsService\StatisticsInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class InterviewStatistics implements StatisticsInterface
{
    protected $interview_repository;

    public function __construct()
    {
        $this->interview_repository = App::make(InterviewRepositoryInterface::class);
    }


    public function getStatistics()
    {
        return $this->generateStatistics();
    }


    protected function generateStatistics(){
         DB::table('interview_statistics')->insert([
            "interviews_all_time"=>DB::table('interviews')->count(),
            "interviews_month"=>DB::table('interviews')->whereBetween('interview_time', [now()->subMonth(), now()])->count(),
            "interviews_week"=>DB::table('interviews')->whereBetween('interview_time', [now()->subWeek(), now()])->count(),
            "interviews_today"=>DB::table('interviews')->whereDate('interview_time', now())->count(),
            "interviews_tomorrow"=>DB::table('interviews')->whereDate('interview_time', now()->addDay())->count(),
            "interviews_in_week"=>DB::table('interviews')->whereBetween('interview_time', [ now(), now()->addWeek()])->count(),
            "interviews_in_month"=>DB::table('interviews')->whereBetween('interview_time', [now(), now()->addMonth()])->count(),
            "created_at"=>now(),
            "updated_at"=>now()
        ]);

        return $this->getArray();
    }

    protected function getArray(){
        return (array) DB::table('interview_statistics')->orderBy('created_at', 'desc')->first();
    }






}