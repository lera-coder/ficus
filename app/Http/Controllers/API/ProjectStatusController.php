<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProjectStatusRequest;
use App\Models\ProjectStatus;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;
use App\Services\ModelService\ProjectStatusService\ProjectStatusServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectStatusController extends Controller
{
    protected $project_status_repository;
    protected $project_status_service;

    public function __construct(ProjectStatusRepositoryInterface $project_status_repository,
                                ProjectStatusServiceInterface $project_status_service)
    {
        $this->project_status_repository = $project_status_repository;
        $this->project_status_service = $project_status_service;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->project_status_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(ProjectStatusRequest $request)
    {
        return $this->project_status_service->create($request->only(['name']));
    }

    /**
     * @param ProjectStatus $projectStatus
     * @return Response
     */
    public function show($id)
    {
        return $this->project_status_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param ProjectStatus $projectStatus
     * @return Response
     */
    public function update(ProjectStatusRequest $request, $id)
    {
        return $this->project_status_service->update($id, $request->only('name'));
    }

    /**
     * @param ProjectStatus $projectStatus
     * @return Response
     */
    public function destroy($id)
    {
        return $this->project_status_service->destroy($id);
    }
}
