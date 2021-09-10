<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ApplicantStatusRequests\ApplicantStatusRequest;
use App\Models\ApplicantStatus;
use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;
use App\Services\ModelService\ApplicantStatusService\ApplicantStatusServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicantStatusController extends Controller
{
    protected $applicant_status_repository;
    protected $applicant_status_service;

    public function __construct(ApplicantStatusRepositoryInterface $applicant_status_repository,
                                ApplicantStatusServiceInterface $applicant_status_service)
    {
        $this->applicant_status_repository = $applicant_status_repository;
        $this->applicant_status_service = $applicant_status_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->applicant_status_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(ApplicantStatusRequest $request)
    {
        return $this->applicant_status_service->create($request->only(['name']));
    }

    /**
     * @param ApplicantStatus $applicantStatus
     * @return Response
     */
    public function show($id)
    {
        return $this->applicant_status_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param ApplicantStatus $applicantStatus
     * @return Response
     */
    public function update(ApplicantStatusRequest $request, $id)
    {
        return $this->applicant_status_service->update($request->only(['name']), $id);
    }

    /**
     * @param ApplicantStatus $applicantStatus
     * @return Response
     */
    public function destroy($id)
    {
        return $this->applicant_status_service->destroy($id);
    }
}
