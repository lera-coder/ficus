<?php


namespace App\Repositories;


use App\Models\Worker;
use App\Models\WorkerPhone;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;

class WorkerPhoneRepository implements WorkerPhoneRepositoryInterface
{
    public $worker_phone;

    public function __construct(WorkerPhone $worker_phone)
    {
        $this->worker_phone = $worker_phone;
    }

    public function all($n)
    {
        return $this->worker_phone->paginate($n);
    }

    public function getById($id)
    {
        return $this->worker_phone->findOrFail($id);
    }

    public function worker($id){
        return $this->getById($id)->worker;
    }
}
