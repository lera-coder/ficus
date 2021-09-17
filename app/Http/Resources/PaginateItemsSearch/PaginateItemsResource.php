<?php

namespace App\Http\Resources\PaginateItemsSearch;

use App\Http\Resources\ProjectResources\ProjectFullResource;
use App\Http\Resources\UserResources\UserFullResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateItemsResource extends JsonResource
{

    protected $resources_dependency_array = [
        "User" => UserFullResource::class,
        "Project" => ProjectFullResource::class
    ];

    protected $models_dependency_array = [
        "User" => User::class,
        "Project" => Project::class
    ];

    public function __construct($resource)
    {

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            new $this->resources_dependency_array[$this->model]
            ($this->models_dependency_array[$this->model]::find($this->id))
        ];
    }
}
