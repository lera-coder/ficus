<?php

namespace App\Http\Resources\ResourcesForPhoneBook;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PhoneBookUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
