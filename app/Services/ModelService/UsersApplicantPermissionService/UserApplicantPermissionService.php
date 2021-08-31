<?php


namespace App\Services\ModelService\UsersApplicantPermissionService;

use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;

class UserApplicantPermissionService implements UserApplicantPermissionServiceInterface
{

    protected $user_applicant_permission_repository;

    public function __construct(UserApplicantPermissionRepositoryInterface $user_applicant_permission_repository)
    {
        $this->user_applicant_permission_repository = $user_applicant_permission_repository;
    }


    public function destroy($id)
    {
       return $this->user_applicant_permission_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->user_applicant_permission_repository->user_applicant_permission->create($data);
    }
}
