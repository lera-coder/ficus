<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\PhoneRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserApplicantPermissionResources\ApplicantPermissionForUsersCollection;
use App\Models\User;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\ModelServiceInterface;
use App\Services\ModelService\UserService\UserServiceInterface;
use Illuminate\Http\Request;



class UserController extends Controller
{
    protected $user_repository;
    protected $user_services;
    protected $user_applicant_permission_repository;


    public function __construct(UserRepositoryInterface $user_repository,
                                UserServiceInterface $user_services,
                                UserApplicantPermissionRepositoryInterface $user_applicant_permission_repository)
    {
        $this->user_repository = $user_repository;
        $this->user_services = $user_services;
        $this->user_applicant_permission_repository = $user_applicant_permission_repository;
    }


    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->user_repository->all(20);
    }


    /**
     * @param Request $request
     */
    public function store(CreateUserRequest $request)
    {
        return $this->user_services->create($request->only(['name', 'login', 'email', 'password']));
    }


    /**
     * Function to retrieve one user
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->user_repository->getById($id);
    }


    /**
     * Function to update one user
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateUserRequest $request, $id)
    {
        return $this->user_services->update($id, $request->all());
    }


    /**
     * Function to destroy user
     *
     * @param $id
     */
    public function destroy($id)
    {
        $this->user_services->destroy($id);
    }



    /**
     * Function to turn on 2FA
     *
     * @param $activity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function toggle2FAAuth(){
        return $this->user_services->toggle2FA(auth()->user()) ?
            response('Your 2Auth was successfully turned on'):
            response('Your 2Auth was successfully turned down');
    }


    public function permissions($id){
        return new ApplicantPermissionForUsersCollection
                             ($this->user_applicant_permission_repository
                             ->getByUser($id));
    }


}
