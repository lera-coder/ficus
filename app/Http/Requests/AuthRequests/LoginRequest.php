<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\ParentRequest;
use App\Rules\LoginRule;

class LoginRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login"=>["required", "string", new LoginRule()],
            "password"=>"required|string"
        ];
    }


}
