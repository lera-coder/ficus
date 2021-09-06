<?php

namespace App\Http\Requests\WorkerPositionRequests;

use App\Http\Requests\ParentRequest;

class WorkerPositionRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|unique:project_statuses,name|alpha_dash"
        ];
    }
}
