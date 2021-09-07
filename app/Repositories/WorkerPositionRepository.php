<?php


namespace App\Repositories;


use App\Models\WorkerPosition;
use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;

class WorkerPositionRepository implements WorkerPositionRepositoryInterface
{
    public $model;

    public function __construct(WorkerPosition $worker_position)
    {
        $this->model = $worker_position;
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
    public function workers($id)
    {
        return $this->getById($id)->workers;
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
