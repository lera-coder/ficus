<?php

namespace App\Http\Requests\KnowledgeRequests;


use App\Http\Requests\ParentRequest;

class UpdateKnowledgeRequest extends ParentRequest
{
    protected $route_to_applicant = 'App\Models\Applicant';
    protected $route_to_user = 'App\Models\User';


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "year_start" => "integer|between:1985,2021",

            //check if user already has this this technology
            "technology_id" => ["exists:technologies,id"],
            "level_id" => "exists:levels,id"
        ];
    }
}
