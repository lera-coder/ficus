<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\PhoneRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\ModelServiceInterface;
use App\Services\ModelService\UserService\UserServiceInterface;
use Illuminate\Http\Request;



class UserController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(UserRepositoryInterface $repository, UserServiceInterface $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    /**
     * Function to retrieve all users
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->repository->all(20);
    }


    /**
     * Function to create new user
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }


    /**
     * Function to retrieve one user
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->repository->getById($id);
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
        return $this->service->update($id, $request->all());
    }


    /**
     * Function to destroy user
     *
     * @param $id
     */
    public function destroy($id)
    {
        $this->service->destroy($id);
    }




    /**
     * Function to turn on 2FA
     *
     * @param $activity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function toggle2FAAuth(){
        return $this->service->toggle2FA(auth()->user()->id);
    }




}
