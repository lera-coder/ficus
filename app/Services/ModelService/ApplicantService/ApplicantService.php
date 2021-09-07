<?php


namespace App\Services\ModelService\ApplicantService;

use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ApplicantService implements ApplicantServiceInterface
{
    protected $applicant_repository;

    public function __construct(ApplicantRepositoryInterface $applicant_repository)
    {
        $this->applicant_repository = $applicant_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return Builder
     */
    public function update($id, $data): Builder
    {
        return $this->applicant_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->applicant_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return Builder
     */
    public function create($data): Builder
    {
        return $this->applicant_repository->model->create($data);
    }
}
