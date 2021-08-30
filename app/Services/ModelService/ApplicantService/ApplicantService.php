<?php


namespace App\Services\ModelService\ApplicantService;

use App\Repositories\Interfaces\ApplicantRepositoryInterface;

class ApplicantService implements ApplicantServiceInterface
{
    protected $applicant_repository;

    public function __construct(ApplicantRepositoryInterface $applicant_repository)
    {
        $this->applicant_repository = $applicant_repository;
    }

    public function update($id, $data)
    {
        return $this->applicant_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->applicant_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->applicant_repository->applicant->create($data);
    }
}
