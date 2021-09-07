<?php

namespace App\Repositories;

use App\Models\UserApplicantPermission;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HigherOrderCollectionProxy;

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
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function user($id)
    {
        return $this->getById($id)->user;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function applicant($id)
    {
        return $this->getById($id)->applicant;
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function permission($id)
    {
        return $this->getById($id)->permission;
    }


    /**
     * @param $id
     * @return Builder[]|Collection
     */
    public function getByApplicant($id)
    {
        return $this->model->query()->where('applicant_id', $id)->get();
    }

    /**
     * @param $id
     * @return Builder[]|Collection
     */
    public function getByUser($id)
    {
        return $this->model->query()->where('user_id', $id)->get();
    }


    public function getByInterview($id)
    {
        $applicants_keys = $this->interview_repository->applicants($id)->modelkeys();
        return $this->model
            ->query()
            ->whereIn('applicant_id', $applicants_keys)
            ->get();
    }
}
