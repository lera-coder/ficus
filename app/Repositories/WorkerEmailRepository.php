<?php


namespace App\Repositories;


use App\Models\WorkerEmail;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;

class WorkerEmailRepository implements WorkerEmailRepositoryInterface
{
    public $model;

    public function __construct(WorkerEmail $worker_email)
    {
        return $this->model = $worker_email;
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
    public function worker($id)
    {
        return $this->getById($id)->worker;
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
