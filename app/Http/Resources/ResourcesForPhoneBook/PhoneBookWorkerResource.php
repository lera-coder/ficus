<?php

namespace App\Http\Resources\ResourcesForPhoneBook;

use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PhoneBookWorkerResource extends JsonResource
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
            "company"=>[
                    "id"=>$this->worker_repository->company($this->id)->id,
                    "name"=>$this->worker_repository->company($this->id)->name,
                ],
            "status"=> $this->worker_repository->status($this->id)->name,
            "position"=>$this->worker_repository->position($this->id),
            "phones"=>WorkerPhoneForPhoneBookResource::collection($this->worker_repository->phones($this->id)),
        ];
    }
}
