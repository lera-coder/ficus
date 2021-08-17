<?php

namespace App\Http\Requests;

class UpdatePhoneRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone_number"=>"numeric",
            "phone_country_code"=>"numeric"
        ];
    }
}
