<?php

namespace App\Http\Resources\ProjectResources;

use App\Http\Resources\TechnologyResources\TechnologyResource;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Collection;

class ProjectFullResource extends JsonResource
{

    protected $project_repository;

    public function __construct($resource)
    {
        $this->project_repository = App::make(ProjectRepositoryInterface::class);
        parent::__construct($resource);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "status" => $this->project_repository->status($this->id),
            "users" => $this->project_repository->users($this->id),
            "worker" => $this->project_repository->worker($this->id),
            "technologies" => TechnologyResource::collection($this->project_repository->technologies($this->id))
        ];
    }
}
