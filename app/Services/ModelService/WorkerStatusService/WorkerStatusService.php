<?php


namespace App\Services\ModelService\WorkerStatusService;


use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;

class WorkerStatusService implements WorkerStatusServiceInterface
{
    protected $worker_status_repository;

    public function __construct(WorkerStatusRepositoryInterface $worker_status_repository)
    {
        $this->worker_status_repository = $worker_status_repository;
    }

    public function update($id, $data)
    {
        return $this->worker_status_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->worker_status_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->worker_status_repository->worker_status->create($data);
    }
}
