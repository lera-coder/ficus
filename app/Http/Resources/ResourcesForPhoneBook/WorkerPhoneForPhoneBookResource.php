<?php

namespace App\Http\Resources\ResourcesForPhoneBook;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkerPhoneForPhoneBookResource extends JsonResource
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
            "phone_number"=>$this->phone_number,
            "operator"=>$this->operator
        ];
    }
}
