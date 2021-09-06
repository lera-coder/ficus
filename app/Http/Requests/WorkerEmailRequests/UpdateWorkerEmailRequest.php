<?php

namespace App\Http\Requests\WorkerEmailRequests;

use App\Http\Requests\ParentRequest;

class UpdateWorkerEmailRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "required|unique:worker_emails,email",
        ];
    }
}
