<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Services\ModelService\ProjectService\ProjectServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        return $this->project_repository->all(20);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(CreateProjectRequest $request)
    {
        return $this->project_service->create($request->only(
            ["name", "description", "price", "company_id", "status_id", "worker_id"]));
    }

    /**
     * @param Project $project
     * @return Response
     */
    public function show($id)
    {
        return $this->project_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        return $this->project_service->update($id, $request->only(
            ["name", "description", "price", "company_id", "status_id", "worker_id"]));
    }

    /**
     * @param Project $project
     * @return Response
     */
    public function destroy($id)
    {
        return $this->project_service->destroy($id);
    }
}
