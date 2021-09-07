<?php


namespace App\Services\ModelService\ProjectService;


use App\Exceptions\WorkerNotInThisCompanyException;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\WorkerRepositoryInterface;

class ProjectService implements ProjectServiceInterface
{
    protected $project_repository;
    protected $worker_repository;

    public function __construct(ProjectRepositoryInterface $project_repository,
                                WorkerRepositoryInterface $worker_repository)
    {
        $this->project_repository = $project_repository;
        $this->worker_repository = $worker_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws WorkerNotInThisCompanyException
     */
    public function update($id, $data)
    {
        $data_edited = $this->checkWorkerAndCompanyForMatch($data);
        return $this->project_repository->getById($id)->update($data_edited);
    }


    /**
     * @param $data
     * @return mixed
     * @throws WorkerNotInThisCompanyException
     */
    public function checkWorkerAndCompanyForMatch($data)
    {
        if (array_key_exists('worker_id', $data)) {
            if (array_key_exists('company_id', $data)) {
                if ($this->worker_repository->company($data['worker_id'])->id == $data['company_id']) {
                    return $data;
                } else {
                    throw new WorkerNotInThisCompanyException();
                }
            } else {
                $data['company_id'] = $this->worker_repository->company($data['worker_id'])->id;
            }
        }
        return $data;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->project_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     * @throws WorkerNotInThisCompanyException
     */
    public function create($data)
    {
        $data = $this->checkWorkerAndCompanyForMatch($data);
        return $this->project_repository->model->create($data);
    }


}
