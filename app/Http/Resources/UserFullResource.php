<?php

namespace App\Http\Resources;

use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFullResource extends JsonResource
{
    protected $email_repository;

//    public function __construct($resource, EmailRepositoryInterface $email_repository)
//    {
//        $this->resource = $resource;
//        $this->email_repository = $email_repository;
//    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request, EmailRepositoryInterface $emailRepository)
    {
        return [
            'name'=>$this->name,
            'login'=>$this->login,
            'email'=>new EmailResource($this->email_repository->activeEmail($request)),
//            'disactive_emails'=>new EmailCollection(EmailResource::collection($this->email_repository->disactiveEmails($request))),
//            'phone'=>new PhoneResource($this->activePhone()),
//            'disactive_phones'=>new PhoneCollection(PhoneResource::collection($this->disactivePhones())),
            'network'=>$this->network

        ];
    }
}
