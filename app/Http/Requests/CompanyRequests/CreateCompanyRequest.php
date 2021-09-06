<?php

namespace App\Http\Requests\CompanyRequests;

use App\Http\Requests\ParentRequest;

class CreateCompanyRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "alpha_dash|required"
        ];
    }
}
