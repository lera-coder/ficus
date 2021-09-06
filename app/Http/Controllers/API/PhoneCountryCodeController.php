<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PhoneCountryCodeRequest;
use App\Http\Requests\UpdatePhoneCountryCodeRequest;
use App\Http\Resources\PhoneCollection;
use App\Http\Resources\PhoneFullCollection;
use App\Http\Resources\PhoneFullResource;
use App\Http\Resources\PhoneResource;
use App\Models\PhoneCountryCode;
use App\Repositories\Interfaces\PhoneCountryCodeRepositoryInterface;
use App\Services\ModelService\PhoneCountryCodeService\PhoneCountryCodeServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class PhoneCountryCodeController extends Controller
{
    protected $phone_country_code_repository;
    protected $phone_country_code_service;

    public function __construct(PhoneCountryCodeRepositoryInterface $phone_country_code_repository,
                                PhoneCountryCodeServiceInterface $phone_country_code_service)
    {
        $this->phone_country_code_repository = $phone_country_code_repository;
        $this->phone_country_code_service = $phone_country_code_service;
    }

    /**
     * @return PhoneCountryCode[]|Collection
     */
    public function index()
    {
        return $this->phone_country_code_repository->all(100);
    }

    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function show($id)
    {
        return $this->phone_country_code_repository->getById($id);
    }

    /**
     * @param PhoneCountryCodeRequest $request
     * @return mixed
     */
    public function store(PhoneCountryCodeRequest $request)
    {
        return $this->phone_country_code_service->create($request->all());
    }


    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        return $this->phone_country_code_service->destroy($id);
    }


    /**
     * @param UpdatePhoneCountryCodeRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdatePhoneCountryCodeRequest $request, $id)
    {
        return $this->phone_country_code_service->update($id, $request->all());
    }


    /**
     * @param $id
     * @return mixed
     */
    public function phones($id)
    {
        return $this->phone_country_code_repository->phones($id);
    }
}
