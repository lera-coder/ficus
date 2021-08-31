<?php

namespace App\Http\Resources\WorkerResources;

use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class WorkerResource extends JsonResource
{
    protected $worker_repository;

    public function __construct($resource)
    {
        $this->worker_repository = App::make(WorkerRepositoryInterface::class);
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
            "status"=>$this->worker_repository->status($this->id),
            "position"=>$this->worker_repository->position($this->id)
        ];
    }
}
