<?php

namespace App\Http\Requests;


class RoleRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|alpha_dash|unique:roles,name"
        ];
    }
}
