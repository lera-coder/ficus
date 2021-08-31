<?php

namespace App\Http\Resources\PhoneResources;

use App\Repositories\Interfaces\PhoneRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PhoneResource extends JsonResource
{
    protected $phone_repository;

    public function __construct($resource)
    {
        $this->phone_repository = App::make(PhoneRepositoryInterface::class);
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
            "phone_number"=>$this->phone_number,
            "phone_country_code"=>$this->phoneCountryCode->code,
            "country"=>$this->phoneCountryCode->country
        ];
    }
}
