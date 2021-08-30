<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateApplicantRequest;
use App\Http\Requests\UpdateApplicantRequest;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use App\Services\ModelService\ApplicantService\ApplicantServiceInterface;

class ApplicantController extends Controller
{
    protected $applicant_repository;
    protected $applicant_service;

    public function __construct(ApplicantRepositoryInterface $applicant_repository,
                                ApplicantServiceInterface $applicant_service)
    {
        $this->applicant_repository = $applicant_repository;
        $this->applicant_service = $applicant_service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->applicant_repository->all(20);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(CreateApplicantRequest $request)
    {
        return $this->applicant_service->create($request->
        only(["name", "email", "phone", "description", "status_id"]));
    }

    /**
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->applicant_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicantRequest $request, $id)
    {
        return $this->applicant_service->update($id, $request->
        only(["name", "email", "phone", "description", "status_id"]));
    }

    /**
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->applicant_service->destroy($id);
    }
}
