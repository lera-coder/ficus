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

    public function update($id, $data)
    {
        return $this->applicant_status_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->applicant_status_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->applicant_status_repository->applicant_status->create($data);
    }
}
