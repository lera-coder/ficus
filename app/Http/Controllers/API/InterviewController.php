<?php

namespace App\Http\Controllers\API;

use App\Exceptions\TryToPublishEmptyException;
use App\Http\Requests\InterviewRequests\CreateInterviewRequest;
use App\Http\Requests\InterviewRequests\InterviewFiltrationRequest;
use App\Http\Requests\InterviewRequests\UpdateInterviewRequest;
use App\Http\Resources\UserApplicantPermissionResources\UserApplicantPermissionCollection;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Services\ModelService\InterviewService\InterviewServiceInterface;
use Illuminate\Http\JsonResponse;

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
        $validated_data = $request->validated();
        return $validated_data['status_id'] == 2 ?
            $this->checkCreateInterviewForPublishStatus($validated_data) :
            $this->interview_service->create($validated_data);

    }

    /**
     * Function to check if this interview is filled for publishing
     * @param $validated_data
     * @return mixed
     */
    private function checkCreateInterviewForPublishStatus($validated_data)
    {
        if (key_exists('link', $validated_data) && is_null($validated_data['link']) &&
            key_exists('interview_time', $validated_data) && is_null($validated_data['interview_time']) &&
            key_exists('sending_time', $validated_data) && is_null($validated_data['sending_time']) &&
            key_exists('interview_id', $validated_data) && is_null($validated_data['interview_id'])) {

            $this->interview_service->create($validated_data);
        }

        throw new TryToPublishEmptyException
        ('To publish this interview  you should fill fields: link, interview time, sending time, interviewer');
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
     * @return JsonResponse
     */
    public function filtration(InterviewFiltrationRequest $request)
    {

        return response()->json($this->interview_repository->filtration($request->validated()));
    }


}
