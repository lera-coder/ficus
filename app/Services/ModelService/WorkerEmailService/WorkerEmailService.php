<?php


namespace App\Services\ModelService\WorkerEmailService;


use App\Repositories\Interfaces\WorkerEmailRepositoryInterface;

class WorkerEmailService implements WorkerEmailServiceInterface
{
    protected $worker_email_repository;

    public function __construct(WorkerEmailRepositoryInterface $worker_email_repository)
    {
        $this->worker_email_repository = $worker_email_repository;
    }

    public function update($id, $data)
    {
        return $this->worker_email_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->worker_email_repository->getById($id)->destroy();
    }

    public function create($data){
        return $this->worker_email_repository->worker_email->create($data);
    }
}
