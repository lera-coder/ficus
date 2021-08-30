<?php


namespace App\Repositories;


use App\Models\Worker;
use App\Repositories\Interfaces\WorkerRepositoryInterface;

class WorkerRepository implements WorkerRepositoryInterface
{
    public $worker;

    public function __construct(Worker $worker)
    {
        return $this->worker = $worker;
    }

    public function all($n)
    {
        return $this->worker->paginate($n);
    }

    public function getById($id)
    {
        return $this->worker->findOrFail($id);
    }

    public function emails($id){
        return $this->getById($id)->emails;
    }

    public function phones($id){
        return $this->getById($id)->phones;
    }

    public function position($id){
        return $this->getById($id)->position;
    }

    public function status($id){
        return $this->getById($id)->status;
    }

    public function company($id){
        return $this->getById($id)->company;
    }

    public function projects($id){
        return $this->getById($id)->projects;
    }
}
