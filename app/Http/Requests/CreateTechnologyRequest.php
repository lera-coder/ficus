<?php

namespace App\Http\Requests;

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
            "name"=>"required|unique:technologies,name"
        ];
    }
}
