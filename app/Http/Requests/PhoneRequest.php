<?php

namespace App\Http\Requests;


class PhoneRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone"=>"numeric|required",
            "phone_country_code_id"=>"required|exists:phone_country_codes,id"
        ];
    }
}
