<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailFullResource extends JsonResource
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
            "id"=>$this->id,
            "email"=>$this->email,
            "email_verified_at"=>$this->email_verified_at,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
            "is_active"=>$this->is_active,
            "user"=>new UserResource($this->user)
        ];
    }
}
