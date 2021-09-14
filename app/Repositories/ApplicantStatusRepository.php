<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\ApplicantStatus;
use App\Repositories\Interfaces\ApplicantStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApplicantStatusRepository implements ApplicantStatusRepositoryInterface
{

    public ApplicantStatus $model;

    public function __construct(ApplicantStatus $applicant_status)
    {
        $this->model = $applicant_status;
    }


    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return ApplicantStatus
     * @throws ModelNotFoundException
     */
    public function getById(int $id): ApplicantStatus
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function applicants(int $id): Collection
    {
        return $this->getById($id)->query()->applicants;
    }


}
