<?php


namespace App\Repositories\Interfaces;


use App\Services\ModelService\ModelServiceInterface;

interface UserApplicantPermissionRepositoryInterface extends RepositoryInterface
{
    public function getByApplicant($id);

    public function getByUser($id);

    public function user($id);

    public function applicant($id);

    public function permission($id);

    public function getByInterview($id);
}
