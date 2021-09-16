<?php

namespace App\Http\Resources\TechnologyResources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class TechnologyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
          "id"=>$this->id,
          "name"=>$this->name
        ];
    }
}
