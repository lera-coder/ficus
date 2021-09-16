<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\ProjectRequests\CreateProjectRequest;
use App\Http\Requests\ProjectRequests\UpdateProjectRequest;
use App\Http\Resources\ProjectResources\ProjectFullResourceCollection;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Services\ModelService\ProjectService\ProjectServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
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
     * @param CreateProjectRequest $request
     * @return mixed
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
     * @param UpdateProjectRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        return $this->project_service->update($id, $request->only(
            ["name", "description", "price", "company_id", "status_id", "worker_id"]));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->project_service->destroy($id);
    }

    /**
     * @param string $query
     * @return ProjectFullResourceCollection
     */
    public function search(string $query):ProjectFullResourceCollection{
        return new ProjectFullResourceCollection($this->project_repository->search($query));
    }
}
