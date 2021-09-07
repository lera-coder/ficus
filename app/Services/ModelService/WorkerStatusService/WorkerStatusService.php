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

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->worker_status_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->worker_status_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->worker_status_repository->model->create($data);
    }
}
