<?php

namespace App\Http\Resources\ResourcesForPhoneBook;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PhoneBookUserResource extends JsonResource
{

    protected $user_repository;

    public function __construct($resource)
    {
        $this->user_repository = App::make(UserRepositoryInterface::class);
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
                "login"=>$this->login,
                "email"=>$this->user_repository->activeEmail($this->id)->email,
                "role"=>RoleForPhoneBookResource::collection($this->user_repository->roles($this->id)),
                "active_phone"=> new PhoneResource($this->user_repository->activePhone($this->id)),
                "disactive_phones"=>PhoneResource::collection($this->user_repository->disactivePhones($this->id))
                ];
    }
}
