<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Http\Resources\PhoneFullCollection;
use App\Http\Resources\PhoneFullResource;
use App\Models\Phone;
use App\Models\PhoneCountryCode;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class PhoneController extends Controller
{

    /**
     * Function returns all phones of user
     *
     * @return mixed
     */
    public function index(){
        return new PhoneFullCollection(PhoneFullResource::collection(auth()->user()->phones));
    }



    /**
     * Function to get the active mail of user
     *
     * @return mixed
     */
    public function activePhone(){
        return auth()->user()->activePhone();
    }


    /**
     * Function to show the phone of user by id
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id){
        $phone  = auth()->user()->phones->find($id);
        return $phone ?: response("Phone is not found", 404);
    }



    /**
     * Function to delete model object
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            Phone::destroy($id);
        }catch (JsonException $e){
            return response(['error'=>$e->getMessage()], 404);
        }

    }


    /**
     * Function to create model of phone
     *
     * @param EmailRequest $request
     * @return mixed
     */
    public function store(PhoneRequest $request){
        return auth()->user()->addPhone($request->email);
    }


    /**
     * Function to set phone active
     *
     * @param $id
     * @return mixed
     */
    public function setActive($id){
        return auth()->user()->makePhoneActive($id);
    }


    /**
     * Function to update phone
     *
     * @param UpdatePhoneRequest $request
     * @param $id
     */
    public function update(UpdatePhoneRequest $request, $id){
        if (! Gate::allows('update-phone', Phone::find($id))) {
            return response('You cannot edit not your phone!', 401);
        }

        $phone = Phone::find($id);
        $phone->update($request->all());

        if(array_key_exists('phone_country_code', $request->all()))
            {
                try{
                    $countryCode = PhoneCountryCode::where('code', $request->phone_country_code)->first();
                    $phone->phone_country_code_id = $countryCode->id;
                    $phone->push();
                }
                catch(\Exception $e){
                    return response('Country code is not found!', 404);
                }
            }

        return $phone;
    }
}
