<?php

namespace App\Http\Requests\WorkerPhoneRequests;

use App\Http\Requests\ParentRequest;

class UpdateWorkerPhoneRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone_number"=>"numeric|unique:worker_phones,phone_number",
            "operator"=>"alpha_dash",
        ];
    }
}
