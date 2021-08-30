<?php


namespace App\Repositories;


use App\Models\WorkerEmail;
use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;

class WorkerEmailRepository implements WorkerEmailRepositoryInterface
{
    public $worker_email;

    public function __construct(WorkerEmail $worker_email)
    {
        return $this->worker_email = $worker_email;
    }

    public function all($n)
    {
        return $this->worker_email->paginate($n);
    }

    public function getById($id)
    {
        return $this->worker_email->findOrFail($id);
    }

    public function worker($id){
        return $this->getById($id)->worker;
    }


}
