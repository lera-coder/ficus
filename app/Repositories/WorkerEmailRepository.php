<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\WorkerEmail;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WorkerEmailRepository implements WorkerEmailRepositoryInterface
{
    public WorkerEmail $model;

    public function __construct(WorkerEmail $worker_email)
    {
        return $this->model = $worker_email;
    }

    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function worker(int $id)
    {
        return $this->getById($id)->worker;
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
