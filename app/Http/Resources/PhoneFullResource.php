<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneFullResource extends JsonResource
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
            "phone_number"=>$this->phone_number,
            "phone_country_code"=>$this->phoneCountryCode->code,
            "country"=>$this->phoneCountryCode->country,
            "is_active"=>$this->is_active,
            "user"=>new UserResource($this->user)
        ];
    }
}
