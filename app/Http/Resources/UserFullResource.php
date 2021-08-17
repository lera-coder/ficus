<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserFullResource extends JsonResource
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
            'name'=>$this->name,
            'login'=>$this->login,
            'email'=>new EmailResource($this->activeEmail()),
            'disactive_emails'=>new EmailCollection(EmailResource::collection($this->disactiveEmails())),
            'phone'=>new PhoneResource($this->activePhone()),
            'disactive_phones'=>new PhoneCollection(PhoneResource::collection($this->disactivePhones())),
            'network'=>$this->network

        ];
    }
}
