<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserApplicantPermissionResources\UserApplicantPermissionCollection;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Services\Filtration\InterviewFiltrationService\InterviewFiltrationInterface;
use App\Services\ModelService\InterviewService\InterviewServiceInterface;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->interview_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->interview_service->create($request
            ->only('link', 'interview_time', 'sending_time', 'description', 'interviewer_id', 'status_id'));

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
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        return $this->interview_service->update($id, $request
            ->only('link', 'interview_time', 'sending_time', 'description', 'interviewer_id', 'status_id'));

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
    public function permissions($id){
        return new UserApplicantPermissionCollection
            ($this->user_applicant_permission_repository->getByInterview($id));
    }


    public function filtration($route, InterviewFiltrationInterface $filtration)
    {
        return response()->json( $filtration->apply($route));
//        return $this->interview_repository->getByStatuses($statuses);
    }
}
