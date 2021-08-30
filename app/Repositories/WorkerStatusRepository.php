<?php


namespace App\Repositories;


use App\Models\WorkerStatus;
use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;

class WorkerStatusRepository implements WorkerStatusRepositoryInterface
{
    public $worker_status;

    public function __construct(WorkerStatus $worker_status)
    {
        $this->worker_status = $worker_status;
    }

    public function all($n)
    {
        return $this->worker_status->paginate($n);
    }

    public function getById($id)
    {
        return $this->worker_status->findOrFail($id);
    }

    public function workers($id){
        return $this->getById($id)->workers;
    }
}
