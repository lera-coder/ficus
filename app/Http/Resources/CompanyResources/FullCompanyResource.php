<?php

namespace App\Http\Resources\CompanyResources;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class FullCompanyResource extends JsonResource
{
    protected $company_repository;


    public function __construct($resource)
    {
        $this->company_repository = App::make(CompanyRepositoryInterface::class);
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
            "id"=>$this->id,
            "name"=>$this->name,
            "description"=>$this->description,
            "contact_information"=>$this->contact_information,
            "workers"=>WorkerResource::collection($this->company_repository->workers),
            "projects"=>$this->company_repository->projects,
        ];
    }
}
