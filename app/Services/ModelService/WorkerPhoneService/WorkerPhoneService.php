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

    public function update($id, $data)
    {
        return $this->worker_phone_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->worker_phone_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->worker_phone_repository->worker_phone->create($data);
    }
}
