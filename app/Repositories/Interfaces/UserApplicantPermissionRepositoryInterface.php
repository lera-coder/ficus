<?php


namespace App\Repositories\Interfaces;


use App\Services\ModelService\ModelServiceInterface;

interface UserApplicantPermissionRepositoryInterface extends RepositoryInterface
{
    public function getByApplicant(int $id);

    public function getByUser(int $id);

    public function user(int $id);

    public function applicant(int $id);

    public function permission(int $id);

    public function getByInterview(int $id);
}
