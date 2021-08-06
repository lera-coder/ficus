<?php

namespace App\Http\Requests;

use App\Rules\LoginRule;

class RefreshPasswordEmailRequest extends ParentRequest
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
        ];
    }
}
