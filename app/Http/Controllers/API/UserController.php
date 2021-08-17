<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\PhoneRequest;
use App\Models\User;
use Illuminate\Http\Request;



class UserController extends Controller
{


    /**
     * Function to retrieve all users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Function to create new user
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        User::createNewUser($request->all());
    }


    /**
     * Function to retrieve one user
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return User::find($id);
    }


    /**
     * Function to update one user
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return User::find($id)->update($request->all());
    }


    /**
     * Function to destroy user
     *
     * @param $id
     */
    public function destroy($id)
    {
        User::destroy($id);
    }




    /**
     * Function to turn on 2FA
     *
     * @param $activity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function toggle2FAAuth(){
        return auth()->user()->toggle2FA();
    }


    /**
     * Function to add new email
     *
     * @param EmailRequest $request
     */
    public function addEmail(EmailRequest $request){

    }


    /**
     * @param PhoneRequest $request
     */
    public function addPhone(PhoneRequest $request){
        auth()->user()->addPhone($request->phone_number, $request->phone_country_code);
    }
//
//
//    /**
//     * @param PhoneRequest $request
//     */
//    public function makeActive(PhoneRequest $request){
//        auth()->user()->addPhone($request);
//    }


}
