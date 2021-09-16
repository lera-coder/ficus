<?php

namespace App\Http\Resources\ProjectResources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ProjectFullResourceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
