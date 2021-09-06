<?php


namespace App\Repositories;


use App\Models\ProjectStatus;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;

class ProjectStatusRepository implements ProjectStatusRepositoryInterface
{
    public $project_status;

    public function __construct(ProjectStatus $project_status)
    {
        $this->project_status = $project_status;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->project_status->query()->paginate($n);
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
        return $this->project_status->query()->findOrFail($id);
    }
}
