<?php

namespace App\Http\Requests;

class CreateUserRequest extends ParentRequest
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
            "login"=>"required|unique:users,login|not_regex:/@^.+№/",
            "email"=>"required|unique:users,email",
            "password"=>"required|string|confirmed"
        ];
    }
}
