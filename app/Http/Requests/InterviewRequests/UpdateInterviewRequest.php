<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Rules\ArrayNotEmptyRule;
use App\Rules\CheckForValidInterviewerRule;
use App\Rules\FiltrationArrayCheckRule;
use Illuminate\Support\Facades\App;

class UpdateInterviewRequest extends ParentRequest
{

    protected $applicant_repository;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->applicant_repository = App::make(ApplicantRepositoryInterface::class);
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            "link" => "url",
            "interview_time" => "date_format:Y-m-d H:i:s",
            "sending_time" => "date_format:Y-m-d H:i:s",
            "interviewer_id" => new CheckForValidInterviewerRule(),
            "status_id" => "exists:interview_statuses,id",
            "applicants" => ["array",
                new ArrayNotEmptyRule(),
                new FiltrationArrayCheckRule($this->applicant_repository->getIdsOfApplicantsWithValidStatus())]
        ];
    }
}
