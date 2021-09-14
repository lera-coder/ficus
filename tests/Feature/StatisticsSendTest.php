<?php

namespace Tests\Feature;

use App\Jobs\InterviewStatisticsJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class StatisticsSendTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_statistics_send()
    {

        Queue::fake();

        $response = $this->post('/api/interviews', [
            "description" => "lllalalalal",
            "applicants" => [
                1, 2
            ]
        ]);


        Queue::assertPushed(InterviewStatisticsJob::class);

    }
}
