<?php

namespace App\Http\Requests\TechnologyRequests;

use App\Http\Requests\ParentRequest;

class CreateTechnologyRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|unique:technologies,name"
        ];
    }
}
