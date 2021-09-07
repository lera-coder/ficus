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

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->worker_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->worker_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->worker_repository->model->create($data);
    }
}
