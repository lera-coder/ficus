<?php

namespace App\Http\Resources\UserApplicantPermissionResources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserApplicantPermissionForInterviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
