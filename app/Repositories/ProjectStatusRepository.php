<?php


namespace App\Repositories;


use App\Models\ProjectStatus;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;

class ProjectStatusRepository implements ProjectStatusRepositoryInterface
{
    public $model;

    public function __construct(ProjectStatus $project_status)
    {
        $this->model = $project_status;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function projects($id)
    {
        return $this->getById($id)->projects;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
