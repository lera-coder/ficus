<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Worker;
use App\Models\WorkerPhone;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WorkerPhoneRepository implements WorkerPhoneRepositoryInterface
{
    public $model;

    public function __construct(WorkerPhone $worker_phone)
    {
        $this->model = $worker_phone;
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
     * @return Worker
     * @throws ModelNotFoundException
     */
    public function worker(int $id): Worker
    {
        return $this->getById($id)->query()->worker;
    }

    /**
     * @param int $id
     * @return WorkerPhone
     * @throws ModelNotFoundException
     */
    public function getById(int $id): WorkerPhone
    {
        return $this->model->getModel($id);
    }
}
