<?php

namespace App\Http\Resources\UserApplicantPermissionResources;

use App\Http\Resources\UserResources\UserResource;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ApplicantPermissionForUsersResource extends JsonResource
{

    protected $user_applicant_permission_repository;

    public function __construct($resource)
    {
        $this->user_applicant_permission_repository = App::make(UserApplicantPermissionRepositoryInterface::class);
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "applicant"=>$this->user_applicant_permission_repository->applicant($this->id),
            "permission"=>$this->user_applicant_permission_repository->permission($this->id),
        ];
    }
}
