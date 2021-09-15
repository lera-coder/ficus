<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequests\CreateUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Http\Resources\UserApplicantPermissionResources\ApplicantPermissionForUsersCollection;
use App\Models\User;
use App\Repositories\Interfaces\UserApplicantPermissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\UserService\UserServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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
     * @return User[]|Collection
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


    /***
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->user_repository->getById($id);
    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateUserRequest $request, $id)
    {
        return $this->user_services->update($id, $request->all());
    }


    /***
     * @param $id
     */
    public function destroy($id)
    {
        $this->user_services->destroy($id);
    }


    /***
     * @param $activity
     * @return Application|ResponseFactory|Response
     */
    public function toggle2FAAuth()
    {
        return $this->user_services->toggle2FA(auth()->user()) ?
            response('Your 2Auth was successfully turned on') :
            response('Your 2Auth was successfully turned down');
    }


    /**
     * @param $id
     * @return ApplicantPermissionForUsersCollection
     */
    public function permissions($id)
    {
        return new ApplicantPermissionForUsersCollection
        ($this->user_applicant_permission_repository
            ->getByUser($id));
    }

    public function search($query){
        return  $this->user_repository->search($query);
    }


}
