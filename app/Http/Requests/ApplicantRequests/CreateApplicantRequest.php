<?php

namespace App\Http\Requests\ApplicantRequests;

use App\Http\Requests\ParentRequest;

class CreateApplicantRequest extends ParentRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|alpha",
            "email" => "nullable|unique:applicants,email|unique:emails,email",
            "phone" => "required|numeric|unique:applicants,email|unique:phones,phone_number",
            "status_id" => "nullable|numeric|exists:applicant_statuses,id"
        ];
    }
}
