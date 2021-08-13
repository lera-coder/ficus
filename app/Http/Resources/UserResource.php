<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'=>$this->activeEmail(),
            'disactive_emails'=>$this->disactiveEmails(),
            'phone'=>$this->activePhone(),
            'disactive_phones'=>$this->disactivePhones(),
            'network'=>$this->network

        ];
    }
}
