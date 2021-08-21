<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\EmailRequest;
use App\Http\Resources\EmailFullCollection;
use App\Http\Resources\EmailFullResource;
use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Exception\JsonException;

class EmailController extends Controller
{
    protected $repository;
    protected $service;


    public function __construct(EmailRepositoryInterface $repository, EmailServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    /**
     * Function returns all emails of user
     *
     * @return mixed
     */
    public function index(){
        return new EmailFullCollection(EmailFullResource::collection($this->repository->all(20)));

    }


    /**
     * Function to get the active mail of user
     *
     * @return mixed
     */
    public function activeEmail(){
        return $this->repository->activeEmail(auth()->user()->id);
    }


    /**
     * Function to show the email of user by id
     *
     * @param $id
     * @return EmailFullResource
     */
    public function show($id){
        return new EmailFullResource($this->repository->getById($id));
    }


    /**
     * Function to delete model object
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id){
        return $this->service->destroy($id);

    }


    /**
     * Function to create model of email
     *
     * @param EmailRequest $request
     * @return mixed
     */
    public function store(EmailRequest $request){
        return $this->service->create($request->email, auth()->user()->id);
    }


    /**
     * Function to set email active
     *
     * @param $id
     * @return mixed
     */
    public function setActive($id){
        return $this->service->makeActive($id, auth()->user()->id);
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

        return $this->service->update($id, $request->all());
    }
}
