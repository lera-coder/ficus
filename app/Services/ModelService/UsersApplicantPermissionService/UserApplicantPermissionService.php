<?php


namespace App\Services\ModelService\UsersApplicantPermissionService;

use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;

class UserApplicantPermissionService implements UserApplicantPermissionServiceInterface
{

    protected $user_applicant_permission_repository;

    public function __construct(
        UserApplicantPermissionRepositoryInterface $user_applicant_permission_repository)
    {
        $this->user_applicant_permission_repository = $user_applicant_permission_repository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->user_applicant_permission_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->user_applicant_permission_repository->model->create($data);
    }
}
