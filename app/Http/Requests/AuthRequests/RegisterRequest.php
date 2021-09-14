<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\ParentRequest;

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
            "name" => "required|string",
            "email" => "required|email",
            "login" => "required|string|not_regex:/@^.+№/",
            "password" => "required|string|confirmed",
        ];
    }


}
