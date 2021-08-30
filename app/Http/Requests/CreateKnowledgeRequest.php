<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateKnowledgeRequest extends ParentRequest
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

        $route = ($this->knowledgable_type == "applicant") ? $this->route_to_applicant : $this->route_to_user;

        return [
            "year_start"=>"required|integer|between:1985,2021",
            "knowledgable_type"=>Rule::in(["applicant", "user"]),

            //check is this user or applicant in database
            "knowledgable_id"=>["required","exists:".$this->knowledgable_type."s,id"],

            //check if user already has this this technology
            "technology_id"=>["required", "exists:technologies,id",
                            Rule::unique('knowledge')
                                ->where('knowledgable_type',$route)
                                ->where("knowledgable_id", $this->knowledgable_id)],

            "level_id"=>"exists:levels,id"
        ];
    }

    public function messages()
    {
        return [
            "knowledgable_id.exists"=>ucfirst($this->knowledgable_type)." is not in collection.",
            "knowledgable_type.in"=>"Knowledges may have just users or applicants.",
            "technology_id.unique"=>ucfirst($this->knowledgable_type)." already has this technology, you may firstly delete it or you can also edit it."
        ];
    }
}
