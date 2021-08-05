<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;


/**
 ** @OA\Info(title="Api to Ficus", version="0.1")
 *
 */
class UserController extends Controller
{


    /**
     * @OA\Get(
     * path="/user",
     * summary="Get all users from database",
     * description="Get all users from database with their fields except of password",
     * operationId="user",
     * tags={"user"},
     *
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="Primary key"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Name of user"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="mail",
     *                         description="Email of user",
     *                     ),
     *                     @OA\Property(
     *                         property="login",
     *                         type="string",
     *                         description="Login of user",
     *                     ),
     *
     *
     *                      @OA\Property(
     *                         property="email_verified_at",
     *                         type="timestamps",
     *                         description="Time of verifiing user's mail",
     *                     ),
     *
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="timestamps",
     *                         description="Time of user's registeration",
     *                     ),
     *
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="timestamps",
     *                         description="Time of last user's information changing",
     *                     ),
     *                     example={
     *                         "id": 1,
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "email_verified_at": null,
     *                         "created_at": null,
     *                         "updated_at": null
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     */

    public function index()
    {
        return User::all();
    }



    /**
     * @OA\POST(
     * path="/user",
     * summary="Create an user",
     * description="Add user to database",
     * operationId="user",
     * tags={"user"},
     *
     *
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Name of user"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="mail",
     *                         description="Email of user",
     *                     ),
     *                     @OA\Property(
     *                         property="login",
     *                         type="string",
     *                         description="Login of user",
     *                     ),
     *
     *                    @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         description="Password of user",
     *                     ),
     *
     *                     example={
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "password": "password"
     *                     }
     *                 )
     *
     *
     *         ),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *
     * )
     */
    public function store(Request $request)
    {
        User::createNewUser($request->all());
    }

    /**
     * @OA\Get(
     * path="/user/{user_id}",
     * summary="Get one user from database",
     * description="Get one user from database with his fields except of password",
     * operationId="user",
     * tags={"user"},
     *
     *     @OA\Parameter (
     *      name = "user_id",
     *      in = "path",
     *      description = "id of user, who we want to get",
     *      required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="Primary key"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Name of user"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="mail",
     *                         description="Email of user",
     *                     ),
     *                     @OA\Property(
     *                         property="login",
     *                         type="string",
     *                         description="Login of user",
     *                     ),
     *
     *
     *                      @OA\Property(
     *                         property="email_verified_at",
     *                         type="timestamps",
     *                         description="Time of verifiing user's mail",
     *                     ),
     *
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="timestamps",
     *                         description="Time of user's registeration",
     *                     ),
     *
     *                      @OA\Property(
     *                         property="updated_at",
     *                         type="timestamps",
     *                         description="Time of last user's information changing",
     *                     ),
     *                     example={
     *                         "id": 1,
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "email_verified_at": null,
     *                         "created_at": null,
     *                         "updated_at": null
     *                     }
     *                 )
     *             )
     *         }
     *
     *     )
     *

     * )
     */
    public function show($id)
    {
        return User::find($id);
    }


    /**
     * @OA\Put(
     * path="/user/{user_id}",
     * summary="Update one user from database",
     * description="Update one user from database",
     * operationId="user/{user_id}",
     * tags={"user"},
     *
     *    @OA\Parameter (
     *      name = "user_id",
     *      in = "path",
     *      description = "id of user, who we want to update",
     *      required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         description="User object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Name of user"
     *                     ),
     *
     *                     example={
     *                         "name": "Example name",
     *                     }
     *                 )
     *               )
     *             ),
     *
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        return User::find($id)->update($request->all());
    }

    /**
     * @OA\Delete(
     * path="/user/{user_id}",
     * summary="Delete one user from database",
     * description="Delete one user from database",
     * operationId="user/{user_id}",
     * tags={"user"},
     *
     *    @OA\Parameter (
     *      name = "user_id",
     *      in = "path",
     *      description = "id of user, who we want to delete",
     *      required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *     ),
     *
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *                 )
     *             )
     *         }
     *     )
     * )
     */
    public function destroy($id)
    {
        User::destroy($id);
    }
}
