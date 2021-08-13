<?php

namespace App\Http\Requests;


class RegisterRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|string",
            "email"=>"required|email|unique:emails,email",
            "login"=>"required|string|unique:users,login|not_regex:/@^.+№/",
            "password"=>"required|string|confirmed",
        ];
    }



}
