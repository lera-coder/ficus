<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\WorkerPosition;
use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WorkerPositionRepository implements WorkerPositionRepositoryInterface
{
    public WorkerPosition $model;

    public function __construct(WorkerPosition $worker_position)
    {
        $this->model = $worker_position;
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
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function workers(int $id): Collection
    {
        return $this->getById($id)->workers;
    }

    /**
     * @param int $id
     * @return WorkerPosition
     * @throws ModelNotFoundException
     */
    public function getById(int $id): WorkerPosition
    {
        return $this->model->getModel($id);
    }

}
