<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProjectStatusRequest;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;
use App\Services\ModelService\ProjectStatusService\ProjectStatusServiceInterface;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->project_status_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStatusRequest $request)
    {
        return $this->project_status_service->create($request->only(['name']));
    }

    /**
     * @param  \App\Models\ProjectStatus  $projectStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->project_status_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectStatus  $projectStatus
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectStatusRequest $request, $id)
    {
        return $this->project_status_service->update($id, $request->only('name'));
    }

    /**
     * @param  \App\Models\ProjectStatus  $projectStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->project_status_service->destroy($id);
    }
}
