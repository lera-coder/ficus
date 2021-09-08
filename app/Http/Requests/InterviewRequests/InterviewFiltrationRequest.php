<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Rules\CheckDateForInterviewFiltrationRule;
use App\Rules\CheckStatusesForInterviewFiltrationRule;
use App\Rules\FiltrationArrayCheckRule;
use App\Rules\SortRule;
use Illuminate\Support\Facades\App;

class InterviewFiltrationRequest extends ParentRequest
{
    protected $applicant_repository;
    protected $user_repository;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->applicant_repository = App::make(ApplicantRepositoryInterface::class);
        $this->user_repository = App::make(UserRepositoryInterface::class);
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
            "per_page"=>"integer",
            "sort"=>["string", new SortRule(["interview-date", "applicants", "interviewers"])],
            "statuses" => ["bail",
                "string",
                new CheckStatusesForInterviewFiltrationRule()],

            "interviewers" => ["bail", "string",
                new FiltrationArrayCheckRule($this->user_repository->getInterviewerIds())],

            "applicants" => ["bail", "string",
                new  FiltrationArrayCheckRule($this->applicant_repository->getIdsOfApplicantsWithValidStatus())],

            "interview-dates" => [
                "bail",
                "string",
                new CheckDateForInterviewFiltrationRule()],
        ];
    }
}
