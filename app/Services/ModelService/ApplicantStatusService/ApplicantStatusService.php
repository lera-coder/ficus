<?php


namespace App\Services\ModelService\ApplicantStatusService;

use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;

class ApplicantStatusService implements ApplicantStatusServiceInterface
{
    protected $applicant_status_repository;

    public function __construct(ApplicantStatusRepositoryInterface $applicant_status_repository)
    {
        $this->applicant_status_repository = $applicant_status_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->applicant_status_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->applicant_status_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->applicant_status_repository->model->create($data);
    }
}
