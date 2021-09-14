<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ApplicantRequests\ApplicantMakeUserRequest;
use App\Http\Requests\ApplicantRequests\CreateApplicantRequest;
use App\Http\Requests\ApplicantRequests\UpdateApplicantRequest;
use App\Http\Resources\UserApplicantPermissionResources\UserPermissionForApplicantsCollection;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Services\ModelService\ApplicantService\ApplicantServiceInterface;
use App\Services\ModelService\UserService\UserServiceInterface;

class ApplicantController extends Controller
{
    protected $applicant_repository;
    protected $applicant_service;
    protected $permission_repository;
    protected $user_service;

    public function __construct(ApplicantRepositoryInterface $applicant_repository,
                                ApplicantServiceInterface $applicant_service,
                                UserApplicantPermissionRepositoryInterface $permission_repository,
                                UserServiceInterface $user_service)
    {
        $this->applicant_repository = $applicant_repository;
        $this->applicant_service = $applicant_service;
        $this->permission_repository = $permission_repository;
        $this->user_service = $user_service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->applicant_repository->all(20);
    }


    /**
     * @param CreateApplicantRequest $request
     * @return mixed
     */
    public function store(CreateApplicantRequest $request)
    {
        return $this->applicant_service->create($request->validated());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->applicant_repository->getById($id);
    }


    /**
     * @param UpdateApplicantRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateApplicantRequest $request, $id)
    {
        return $this->applicant_service->update($id, $request->validated());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->applicant_service->destroy($id);
    }


    /**
     * @param $id
     * @return UserPermissionForApplicantsCollection
     */
    public function permissions($id)
    {
        return new UserPermissionForApplicantsCollection($this->permission_repository->getByApplicant($id));
    }


    public function makeUser($id, ApplicantMakeUserRequest $request)
    {
        $applicant = $this->applicant_repository->getById($id);
        $this->applicant_service->update($id, ['status' => 6]);
        $applicant->softDelete();
        return response()->json('Applicant was successfully upgraded to user of this system!');

    }

    public function deny($id)
    {
        return $this->applicant_service->update($id, ['status' => 5]);
    }


}
