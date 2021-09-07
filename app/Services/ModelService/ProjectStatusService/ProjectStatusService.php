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

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->project_status_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->project_status_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->project_status_repository->model->create($data);
    }
}
