<?php

namespace App\Http\Requests;


class CreateProjectRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required",
            "price"=>"required|numeric",
            "worker_id"=>["bail","numeric", "exists:workers,id"],
            "company_id"=>"nullable|numeric|exists:companies,id",
            "status_id"=>"numeric|exists:project_statuses,id",
        ];
    }
}
