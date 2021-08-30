<?php

namespace App\Http\Requests;

class UpdateProjectRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "price"=>"numeric",
            "company_id"=>"nullable|numeric|exists:companies,id",
            "status_id"=>"numeric|exists:project_statuses,id",
            "worker_id"=>"numeric|exists:workers,id"
        ];
    }
}
