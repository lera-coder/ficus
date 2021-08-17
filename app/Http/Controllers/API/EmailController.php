<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\EmailRequest;
use App\Http\Resources\EmailFullCollection;
use App\Http\Resources\EmailFullResource;
use App\Models\Email;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class EmailController extends Controller
{


    /**
     * Function returns all emails of user
     *
     * @return mixed
     */
    public function index(){
        return new EmailFullCollection(EmailFullResource::collection(auth()->user()->emails));

    }


    /**
     * Function to get the active mail of user
     *
     * @return mixed
     */
    public function activeEmail(){
        return auth()->user()->activeEmail();
    }


    /**
     * Function to show the email of user by id
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id){
        $email  = auth()->user()->emails->find($id);
        return $email ?: response("Email is not found", 404);
    }


    /**
     * Function to delete model object
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            Email::destroy($id);
        }catch (JsonException $e){
            return response(['error'=>$e->getMessage()], 404);
        }

    }


    /**
     * Function to create model of email
     *
     * @param EmailRequest $request
     * @return mixed
     */
    public function store(EmailRequest $request){
        return auth()->user()->addEmail($request->email);
    }


    /**
     * Function to set email active
     *
     * @param $id
     * @return mixed
     */
    public function setActive($id){
        return auth()->user()->makeEmailActive($id);
    }


    /**
     * Function to update email
     *
     * @param EmailRequest $request
     * @param $id
     */
    public function update(EmailRequest $request, $id){
        if (! Gate::allows('update-email', Email::find($id))) {
            return response('You cannot edit not your email!', 401);
        }

        $email = Email::find($id);

        if($email->is_active){
            $email->email_verified_at = null;
        }

        $email->update($request->all());
        return $email;
    }
}
