<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Rules\CheckApplicantsArrayRule;
use App\Rules\CheckForValidInterviewerRule;

class UpdateInterviewRequest extends ParentRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            "link" => "url",
            "interview_time" => "datetime:Y-m-d H:i:s",
            "sending_time" => "datetime:Y-m-d H:i:s",
            "interviewer_id" => new CheckForValidInterviewerRule(),
            "status_id" => "exists:interview_statuses,id",
            "applicants" => new CheckApplicantsArrayRule(),
        ];
    }
}
