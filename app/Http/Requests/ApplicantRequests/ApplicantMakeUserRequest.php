<?php

namespace App\Http\Requests\ApplicantRequests;

use App\Http\Requests\ParentRequest;

class ApplicantMakeUserRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "password" => "required|confirmed",
            "login" => "required||not_regex:/@^.+№/",
            "email" => "email"
        ];
    }
}
