<?php

namespace App\Http\Requests;


class ApplicantStatusRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|unique:applicantStatuses,name|not_regex:/@^.+№/"
        ];
    }
}
