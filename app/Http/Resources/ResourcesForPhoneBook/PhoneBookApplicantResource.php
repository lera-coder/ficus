<?php

namespace App\Http\Resources\ResourcesForPhoneBook;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneBookApplicantResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name"=>$this->name,
            "description"=>$this->description,
            "phone"=>$this->phone
        ];
    }
}
