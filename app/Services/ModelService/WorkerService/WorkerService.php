<?php


namespace App\Services\ModelService\WorkerService;

use App\Repositories\Interfaces\WorkerRepositoryInterface;

class WorkerService implements WorkerServiceInterface
{
    protected $worker_repository;

    public function __construct(WorkerRepositoryInterface $worker_repository)
    {
        $this->worker_repository = $worker_repository;
    }


    public function update($id, $data)
    {
        return $this->worker_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->worker_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->worker_repository->worker->create($data);
    }
}
