<?php

namespace App\Http\Resources\UserApplicantPermissionResources;

use App\Http\Resources\UserResources\UserResource;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserPermissionForApplicantsResource extends JsonResource
{

    protected $user_permission_applicant_repository;

    public function __construct($resource)
    {
        $this->user_permission_applicant_repository = App::make(UserApplicantPermissionRepositoryInterface::class);
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
            "user"=>new UserResource($this->user_permission_applicant_repository->user($this->id)),
            "permission"=>$this->user_permission_applicant_repository->permission($this->id),
        ];
    }
}
