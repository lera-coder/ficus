<?php


namespace App\Services\ModelService\WorkerPhoneService;


use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;

class WorkerPhoneService implements WorkerPhoneServiceInterface
{
    protected $worker_phone_repository;

    public function __construct(WorkerPhoneRepositoryInterface $worker_phone_repository)
    {
        $this->worker_phone_repository = $worker_phone_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->worker_phone_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->worker_phone_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->worker_phone_repository->model->create($data);
    }
}
