<?php

namespace App\Http\Resources\ProjectResources;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ProjectResource extends JsonResource
{

    protected $project_repository;

    public function __construct($resource)
    {
        $this->project_repository = App::make(ProjectRepositoryInterface::class);
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name"=>$this->name,
            "description"=>$this->description,
            "price"=>$this->price,
            "status"=>$this->project_repository->status($this->id),
            "users"=>$this->project_repository->users($this->id),
            "worker"=>$this->project_repository->worker($this->id),
        ];
    }
}
