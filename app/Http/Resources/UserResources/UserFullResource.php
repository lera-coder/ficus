<?php

namespace App\Http\Resources\UserResources;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserFullResource extends JsonResource
{
    protected $user_repository;

    public function __construct($resource)
    {
        $this->resource = $resource;
        $this->user_repository = App::make(UserRepositoryInterface::class);

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
            'name'=>$this->name,
            'login'=>$this->login,
            'email'=>new EmailResource($this->user_repository->activeEmail($this->id)),
            'disactive_emails'=> EmailResource::collection($this->user_repository->disactiveEmails($this->id)),
            'phone'=>new PhoneResource($this->user_repository->activePhone($this->id)),
            'disactive_phones'=> PhoneResource::collection($this->user_repository->disactivePhones($this->id)),
            'network'=>$this->network

        ];
    }



}
