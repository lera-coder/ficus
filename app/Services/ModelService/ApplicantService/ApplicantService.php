<?php


namespace App\Services\ModelService\ApplicantService;

use App\Exceptions\UnsuccessfullDeleteException;
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
     * @param int $id
     * @param array $data
     * @return Builder
     */
    public function update(int $id, array $data): Builder
    {
        return $this->applicant_repository->getById($id)->update($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        if (!$this->applicant_repository->model->destroy($id)) {
            throw new UnsuccessfullDeleteException;
        }
        return true;
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
