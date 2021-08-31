<?php

namespace App\Http\Resources\EmailResources;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class EmailFullResource extends JsonResource
{

    protected $email_repository;

    public function __construct($resource)
    {
        $this->email_repository = App::make(EmailRepositoryInterface::class);
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
            "email"=>$this->email,
            "email_verified_at"=>$this->email_verified_at,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
            "is_active"=>$this->is_active,
            "user"=>new UserResource($this->email_repository->user($this->id))
        ];
    }
}
