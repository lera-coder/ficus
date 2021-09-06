<?php

namespace App\Http\Requests\PhoneCountryCodeRequests;

use App\Http\Requests\ParentRequest;

class PhoneCountryCodeRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "code" => "required|numeric",
            "country" => "required|alpha"
        ];
    }
}
