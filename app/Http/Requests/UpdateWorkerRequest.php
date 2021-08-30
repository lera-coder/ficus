<?php

namespace App\Http\Requests;

class UpdateWorkerRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"alpha",
            "company_id"=>"exists:companies,id",
            "status_id"=>"exists:worker_statuses,id",
            "position_id"=>"exists:worker_positions,id"
        ];
    }
}
