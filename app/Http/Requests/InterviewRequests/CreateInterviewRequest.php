<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Rules\CheckForValidInterviewerRule;
use App\Rules\IfOneFieldIsNullOtherShouldBeNullRule;
use App\Rules\TimeNotBiggerThanRule;

class CreateInterviewRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "description"=>"bail|nullable|string",
            "status_id"=>"bail|exists:interview_statuses,id",
            "link"=>"bail|nullable|string",
            "sending_time"=>["bail","nullable", "date_format:Y-m-d H:i:s",
                new IfOneFieldIsNullOtherShouldBeNullRule($this->interview_time, 'interview time') ],
            "interview_time"=>["bail","nullable", "date_format:Y-m-d H:i:s",
                new TimeNotBiggerThanRule($this->sending_time, 'sending time')],
            "interviewer_id"=>["nullable", new CheckForValidInterviewerRule()]
        ];
    }
}
