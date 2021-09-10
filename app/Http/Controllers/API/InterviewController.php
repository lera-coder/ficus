<?php

namespace App\Http\Controllers\API;

use App\Events\InterviewCreated;
use App\Http\Requests\InterviewRequests\CreateInterviewRequest;
use App\Http\Requests\InterviewRequests\InterviewFiltrationRequest;
use App\Http\Requests\InterviewRequests\UpdateInterviewRequest;
use App\Http\Resources\InterviewResources\InterviewFullCollection;
use App\Http\Resources\UserApplicantPermissionResources\UserApplicantPermissionCollection;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Services\ModelService\InterviewService\InterviewServiceInterface;

class InterviewController extends Controller
{
    protected $user_applicant_permission_repository;
    protected $interview_repository;
    protected $interview_service;

    public function __construct(UserApplicantPermissionRepositoryInterface $user_applicant_permission_repository,
                                InterviewRepositoryInterface $interview_repository,
                                InterviewServiceInterface $interview_service)
    {
        $this->user_applicant_permission_repository = $user_applicant_permission_repository;
        $this->interview_repository = $interview_repository;
        $this->interview_service = $interview_service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->interview_repository->all(20);
    }


    /**
     * @param CreateInterviewRequest $request
     * @return mixed
     */
    public function store(CreateInterviewRequest $request)
    {
        $interview = $this->interview_service->create($request->validated());
        event(new InterviewCreated());
        return $interview;

    }


    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->interview_repository->getById($id);
    }


    /**
     * @param UpdateInterviewRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateInterviewRequest $request, $id)
    {
        return $this->interview_service->update($id, $request
            ->only('link',
                'interview_time',
                'sending_time',
                'description',
                'interviewer_id',
                'status_id',
                'applicants'));

    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {

        return $this->interview_service->destroy($id);
    }


    /**
     * @param $interview_id
     * @param $applicant_id
     * @return mixed
     */
    public function deleteApplicantFromInterview($interview_id, $applicant_id)
    {
        return $this->interview_service->deleteAppliacantFromInterview($interview_id, $applicant_id);
    }

    /**
     * @param $id
     * @return UserApplicantPermissionCollection
     */
    public function permissions($id)
    {
        return new UserApplicantPermissionCollection
        ($this->user_applicant_permission_repository->getByInterview($id));
    }


    /**
     * @param InterviewFiltrationRequest $request
     * @return InterviewFullCollection
     */
    public function filtration(InterviewFiltrationRequest $request)
    {
        $request_to_array = $this->interview_service->makeValidFiltrationArray($request->validated());
        return new InterviewFullCollection(
            ($this->interview_repository->filtration($request_to_array)));

    }


}
