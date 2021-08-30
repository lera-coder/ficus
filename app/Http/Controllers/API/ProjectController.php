<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Services\ModelService\ProjectService\ProjectServiceInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    protected $project_repository;
    protected $project_service;

    public function __construct(ProjectRepositoryInterface $project_repository,
                                ProjectServiceInterface $project_service)
    {
        $this->project_repository = $project_repository;
        $this->project_service = $project_service;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->project_repository->all(20);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {
        return $this->project_service->create($request->only(
            ["name", "description", "price", "company_id", "status_id", "worker_id"]));
    }

    /**
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->project_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        return $this->project_service->update($id, $request->only(
            ["name", "description", "price", "company_id", "status_id", "worker_id"]));
    }

    /**
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->project_service->destroy($id);
    }
}
