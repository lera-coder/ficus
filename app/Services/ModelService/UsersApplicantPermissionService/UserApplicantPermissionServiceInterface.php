<?php


namespace App\Services\ModelService\UsersApplicantPermissionService;

use App\Services\ModelService\ModelServiceInterface;

interface UserApplicantPermissionServiceInterface
{
    public function destroy($id);

    public function create($data);

}
