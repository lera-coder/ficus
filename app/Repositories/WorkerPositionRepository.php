<?php


namespace App\Repositories;


use App\Models\WorkerPosition;
use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;

class WorkerPositionRepository implements WorkerPositionRepositoryInterface
{
    public $worker_position;

    public function __construct(WorkerPosition $worker_position)
    {
        $this->worker_position = $worker_position;
    }

    public function all($n)
    {
       return $this->worker_position->paginate($n);
    }

    public function getById($id)
    {
        return $this->worker_position->findOrFail($id);
    }

    public function workers($id)
    {
        return $this->getById($id)->workers;
    }

}
