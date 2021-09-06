<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\EmailRequest;
use App\Http\Resources\EmailFullCollection;
use App\Http\Resources\EmailFullResource;
use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class EmailController extends Controller
{
    protected $email_repository;
    protected $email_service;


    public function __construct(EmailRepositoryInterface $email_repository, EmailServiceInterface $email_service)
    {
        $this->email_repository = $email_repository;
        $this->email_service = $email_service;
    }


    /**
     * @return mixed
     */
    public function index()
    {
        return new EmailFullCollection(EmailFullResource::collection($this->email_repository->all(20)));

    }


    /**
     * @return mixed
     */
    public function activeEmail()
    {
        return $this->email_repository->activeEmail(auth()->user()->id);
    }


    /**
     * @param $id
     * @return EmailFullResource
     */
    public function show($id)
    {
        return new EmailFullResource($this->email_repository->getById($id));
    }


    /**
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy($id)
    {
        return $this->email_service->destroy($id);

    }


    /**
     * @param EmailRequest $request
     * @return mixed
     */
    public function store(EmailRequest $request)
    {
        return $this->email_service->create($request->email);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function setActive($id)
    {
        return $this->email_service->makeActive($id);
    }


    /**
     * @param EmailRequest $request
     * @param $id
     */
    public function update(EmailRequest $request, $id)
    {
        if (!Gate::allows('update-email', Email::find($id))) {
            return response('You cannot edit not your email!', 401);
        }

        return $this->email_service->update($id, $request->only(['email']));
    }

}
