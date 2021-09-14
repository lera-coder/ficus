<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Rules\ArrayNotEmptyRule;
use App\Rules\CheckForValidInterviewerRule;
use App\Rules\FiltrationArrayCheckRule;
use App\Rules\IfOneFieldIsNullOtherShouldBeNullRule;
use App\Rules\TimeNotBiggerThanRule;
use Illuminate\Support\Facades\App;

class CreateInterviewRequest extends ParentRequest
{
    protected $applicant_repository;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->applicant_repository = App::make(ApplicantRepositoryInterface::class);
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

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
            "link"=>"bail|nullable|url",
            "sending_time"=>["bail","nullable", "date_format:Y-m-d H:i:s",
                new IfOneFieldIsNullOtherShouldBeNullRule($this->interview_time, 'interview time') ],
            "interview_time"=>["bail","nullable", "date_format:Y-m-d H:i:s",
                new TimeNotBiggerThanRule($this->sending_time, 'sending time')],
            "interviewer_id"=>["nullable",
                new CheckForValidInterviewerRule()],
            "applicants"=>["bail","required","array",
                new ArrayNotEmptyRule(),
                ]
        ];
    }
}
