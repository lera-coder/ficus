<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Company;
use App\Models\Worker;
use App\Models\WorkerPosition;
use App\Models\WorkerStatus;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class WorkerRepository implements WorkerRepositoryInterface
{
    public Worker $model;

    public function __construct(Worker $worker)
    {
        return $this->model = $worker;
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
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function emails(int $id): Collection
    {
        return $this->getById($id)->emails;
    }


    /**
     * @param int $id
     * @return Worker
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Worker
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function phones(int $id): Collection
    {
        return $this->getById($id)->phones;
    }


    /**
     * @param int $id
     * @return WorkerPosition
     * @throws ModelNotFoundException
     */
    public function position(int $id): WorkerPosition
    {
        return $this->getById($id)->query()->position;
    }


    /**
     * @param int $id
     * @return WorkerStatus
     * @throws ModelNotFoundException
     */
    public function status(int $id): WorkerStatus
    {
        return $this->getById($id)->query()->status;
    }


    /**
     * @param int $id
     * @return Company
     * @throws ModelNotFoundException
     */
    public function company(int $id): Company
    {
        return $this->getById($id)->company;
    }


    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function projects(int $id): Collection
    {
        return $this->getById($id)->query()->projects;
    }
}
