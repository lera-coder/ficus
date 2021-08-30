<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Http\Resources\PhoneFullCollection;
use App\Http\Resources\PhoneFullResource;
use App\Models\Phone;
use App\Models\PhoneCountryCode;
use App\Repositories\Interfaces\PhoneRepositoryInterface;
use App\Services\ModelService\PhoneService\PhoneServiceInterface;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class PhoneController extends Controller
{
    protected $phone_repository;
    protected $phone_service;

    public function __construct(PhoneServiceInterface $phone_service,
                                PhoneRepositoryInterface $phone_repository)
    {
        $this->phone_repository = $phone_repository;
        $this->phone_service = $phone_service;
    }

    /**
     * @return mixed
     */
    public function index(){
        return new PhoneFullCollection(PhoneFullResource::collection($this->phone_repository->all(20)));
    }



    /**
     * @return mixed
     */
    public function activePhone(){
        return $this->phone_repository->activePhone(auth()->user());
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id){
       return $this->phone_repository->getById($id);
    }



    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id){
        $this->phone_service->destroy(($id));
    }


    /**
     * @param PhoneRequest $request
     * @return mixed
     */
    public function store(PhoneRequest $request){
        return $this->phone_service->create($request->only(['phone_number', 'phone_country_code_id']));
    }


    /**
     * Function to set phone active
     *
     * @param $id
     * @return mixed
     */
    public function setActive($id){
        return $this->phone_service->makeActive($id) ?
            response('Phone was successfully turned to active'):
            response('This action is not allowed', 403);

    }


    /**
     * @param UpdatePhoneRequest $request
     * @param $id
     */
    public function update(UpdatePhoneRequest $request, $id){
        if (! Gate::allows('update-phone', Phone::find($id))) {
            return response('You cannot edit not your phone!', 401);
        }

        return $this->phone_service->update($id, $request->only(['phone_number', 'phone_country_code_id']));
    }
}
