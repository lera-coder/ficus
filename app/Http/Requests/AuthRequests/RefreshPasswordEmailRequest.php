<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\ParentRequest;

class RefreshPasswordEmailRequest extends ParentRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "login" => 'required',
        ];
    }
}
