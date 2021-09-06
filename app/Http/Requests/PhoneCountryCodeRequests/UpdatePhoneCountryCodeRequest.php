<?php

namespace App\Http\Requests\PhoneCountryCodeRequests;

use App\Http\Requests\ParentRequest;

class UpdatePhoneCountryCodeRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "country" => "required|alpha",
            "code" => "prohibited"
        ];
    }


    public function messages()
    {
        return [
            "code.prohibited" => "Sorry, you cannot edit the country code, just the name of country!"
        ];
    }
}
