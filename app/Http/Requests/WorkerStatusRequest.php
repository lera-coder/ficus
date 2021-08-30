<?php

namespace App\Http\Requests;

class WorkerStatusRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|unique:worker_statuses,name|alpha_dash"
        ];
    }
}
