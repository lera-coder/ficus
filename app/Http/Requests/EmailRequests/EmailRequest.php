<?php

namespace App\Http\Requests\EmailRequests;

use App\Http\Requests\ParentRequest;

class EmailRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "email|unique:emails,email|required"
        ];
    }
}
