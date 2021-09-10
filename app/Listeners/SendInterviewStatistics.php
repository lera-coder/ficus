<?php

namespace App\Listeners;

use App\Events\InterviewCreated;
use App\Jobs\InterviewStatisticsJob;


class SendInterviewStatistics
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InterviewCreated  $event
     * @return void
     */
    public function handle(InterviewCreated $event)
    {
        dispatch(new InterviewStatisticsJob());
    }
}
