<?php


namespace App\Services\ModelService\ProjectStatusService;


use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;

class ProjectStatusService implements ProjectStatusServiceInterface
{

    protected $project_status_repository;

    public function __construct(ProjectStatusRepositoryInterface $project_status_repository)
    {
        $this->project_status_repository = $project_status_repository;
    }

    public function update($id, $data)
    {
        return $this->project_status_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->project_status_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->project_status_repository->project_status->create($data);
    }
}
