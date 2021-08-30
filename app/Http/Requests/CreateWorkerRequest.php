<?php

namespace App\Http\Requests;

class CreateWorkerRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|alpha",
            "company_id"=>"required|exists:companies,id",
            "position_id"=>"required|exists:positions,id",
            "status_id"=>"exists:worker_statuses,id"
        ];
    }
}
