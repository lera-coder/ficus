<?php

namespace App\Http\Requests;

class CreateWorkerEmailRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email"=>"required|unique:worker_emails,email",
            "worker_id"=>"required|exists:workers,id"
        ];
    }
}
