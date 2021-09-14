<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\WorkerStatus;
use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WorkerStatusRepository implements WorkerStatusRepositoryInterface
{
    public WorkerStatus $model;

    public function __construct(WorkerStatus $worker_status)
    {
        $this->model = $worker_status;
    }

    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function workers(int $id): Collection
    {
        return $this->getById($id)->query()->workers;
    }

    /**
     * @param int $id
     * @return WorkerStatus
     * @throws ModelNotFoundException
     */
    public function getById(int $id): WorkerStatus
    {
        return $this->model->getModel($id);
    }
}
