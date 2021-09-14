<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Applicant;
use App\Models\ApplicantStatus;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApplicantRepository implements ApplicantRepositoryInterface
{
    public Applicant $model;

    /**
     * @param Applicant $applicant
     */
    public function __construct(Applicant $applicant)
    {
        $this->model = $applicant;
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
     * @return Applicant
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Applicant
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return ApplicantStatus
     * @throws ModelNotFoundException
     */
    public function status(int $id): ApplicantStatus
    {
        return $this->getById($id)->query()->status;
    }


    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function knowledges(int $id): Collection
    {
        return $this->getById($id)->query()->knowledges;
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function interviews(int $id): Collection
    {
        return $this->getById($id)->query()->interviews;
    }

    /**
     * @return array
     */
    public function getIdsOfApplicantsWithValidStatus(): array
    {
        return $this->model->all()->whereNotIn('status_id', [5, 6])->pluck('id')->toArray();
    }
}
