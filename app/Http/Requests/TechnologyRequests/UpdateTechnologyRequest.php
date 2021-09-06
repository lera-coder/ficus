<?php

namespace App\Http\Requests\TechnologyRequests;

use App\Http\Requests\ParentRequest;

class UpdateTechnologyRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "unique:technologies,name"
        ];
    }
}
