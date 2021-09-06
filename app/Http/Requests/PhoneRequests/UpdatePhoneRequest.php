<?php

namespace App\Http\Requests\PhoneRequests;

use App\Http\Requests\ParentRequest;

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
            "phone_number" => "numeric",
            "phone_country_code_id" => "exists:phone_country_codes,id"
        ];
    }
}
