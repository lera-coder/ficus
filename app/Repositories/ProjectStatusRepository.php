<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\ProjectStatus;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectStatusRepository implements ProjectStatusRepositoryInterface
{
    public ProjectStatus $model;

    public function __construct(ProjectStatus $project_status)
    {
        $this->model = $project_status;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function projects(int $id)
    {
        return $this->getById($id)->projects;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }


}
