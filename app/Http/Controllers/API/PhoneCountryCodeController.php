<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PhoneCountryCodeRequest;
use App\Http\Requests\UpdatePhoneCountryCodeRequest;
use App\Http\Resources\PhoneCollection;
use App\Http\Resources\PhoneFullCollection;
use App\Http\Resources\PhoneFullResource;
use App\Http\Resources\PhoneResource;
use App\Models\PhoneCountryCode;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PhoneCountryCodeController extends Controller
{
    /**
     * Get all Country codes
     *
     * @return PhoneCountryCode[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(){
        return PhoneCountryCode::all();
    }

    /**
     * Get PhoneCountryCode by id
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id){
        return PhoneCountryCode::find($id)?:response("Country code is not found", 401);
    }

    /**
     * Function to create new Country code
     *
     * @param PhoneCountryCodeRequest $request
     * @return mixed
     */
    public function store(PhoneCountryCodeRequest $request){
        return PhoneCountryCode::create($request->all());
    }


    /**
     * Function to delete Country Code
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id){
        if(PhoneCountryCode::find($id)->phones()->count()){
            return response('Sorry, but this Country code is used', 401);
        }

        PhoneCountryCode::destroy($id);
        return response('Country code was successfully deleted!');
    }


    /**
     * Function to update Country in model country code
     *
     * @param UpdatePhoneCountryCodeRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdatePhoneCountryCodeRequest $request, $id){

        $countryCode = PhoneCountryCode::find($id);
        $countryCode->update(["country"=> $request->country]);
        return $countryCode;
    }


    /**
     * Function to retrieve all phones in this country
     *
     * @param $id
     * @return mixed
     */
    public function phones($id){
        try {
            return new PhoneFullCollection(PhoneFullResource::collection(PhoneCountryCode::find($id)->phones));
        }
        catch (\Exception $e){
            return response('Counry code in not found', 404);
        }
    }
}
