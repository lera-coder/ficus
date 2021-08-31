<?php

namespace App\Http\Resources\EmailResources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
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
            'email'=>$this->email,
            'email_verified_at'=>$this->email_verified_at,
        ];
    }
}
