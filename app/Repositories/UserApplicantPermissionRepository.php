<?php

namespace App\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Models\UserApplicantPermission;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserApplicantPermissionRepository implements UserApplicantPermissionRepositoryInterface
{
    public $model;
    protected $interview_repository;

    public function __construct(UserApplicantPermission $user_applicant_permission,
                                InterviewRepositoryInterface $interview_repository)
    {
        $this->model = $user_applicant_permission;
        $this->interview_repository = $interview_repository;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function user($id)
    {
        return $this->getById($id)->user;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function applicant(int $id)
    {
        return $this->getById($id)->applicant;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function permission(int $id)
    {
        return $this->getById($id)->permission;
    }


    /**
     * @param int $id
     * @return Collection
     */
    public function getByApplicant(int $id): Collection
    {
        return $this->model->query()->where('applicant_id', $id)->get();
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getByUser(int $id): Collection
    {
        return $this->model->query()->where('user_id', $id)->get();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getByInterview(int $id): Collection
    {
        $applicants_keys = $this->interview_repository->applicants($id)->modelkeys();
        return $this->model
            ->query()
            ->whereIn('applicant_id', $applicants_keys)
            ->get();
    }
}
