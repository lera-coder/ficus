<?php

namespace App\Http\Requests\InterviewRequests;

use App\Http\Requests\ParentRequest;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Rules\ArrayNotEmptyRule;
use App\Rules\CheckDateForInterviewFiltrationRule;
use App\Rules\CheckStatusesForInterviewFiltrationRule;
use App\Rules\FiltrationArrayCheckRule;
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
            "status" => ["bail",
                "array",
                new ArrayNotEmptyRule(),
                new CheckStatusesForInterviewFiltrationRule()],

            "interviewer" => ["bail", "array",
                new ArrayNotEmptyRule(),
                new FiltrationArrayCheckRule($this->user_repository->getInterviewerIds())],

            "applicant" => ["bail", "array",
                new ArrayNotEmptyRule(),
                new  FiltrationArrayCheckRule($this->applicant_repository->getIdsOfApplicantsWithValidStatus())],

            "interview-date" => [
                "bail",
                "array",
                new ArrayNotEmptyRule(),
                new CheckDateForInterviewFiltrationRule()],
        ];
    }
}
