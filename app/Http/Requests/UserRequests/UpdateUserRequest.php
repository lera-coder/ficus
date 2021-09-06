<?php

namespace App\Http\Requests\UserRequests;

use App\Http\Requests\ParentRequest;

class UpdateUserRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "alpha",
            "login" => "unique:users,login|not_regex:/@^.+№/",
            "email" => "unique:users,email",
            "password" => "string|confirmed"
        ];
    }
}
