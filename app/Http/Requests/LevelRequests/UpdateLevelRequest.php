<?php

namespace App\Http\Requests\LevelRequests;

use App\Http\Requests\ParentRequest;

class UpdateLevelRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "alpha_dash"
        ];
    }
}
