<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{

    /**
     * @OA\POST(
     * path="/login",
     * summary="Path to log in",
     * description="The way to log in for users, who are registered.",
     * operationId="login",
     * tags={"auth"},
     *
     *
     *     @OA\RequestBody(
     *         description="The personal information of registered users. In field login user can enter login or email",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                     @OA\Property(
     *                         property="login",
     *                         type="string",
     *                         description="Login of user",
     *                     ),
     *
     *
     *                      @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         description="User's password",
     *                     ),
     *
     *                     example={
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
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
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         description="The token, that user uses to log in"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         description="Type of token"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         description="Time in minutes to token expire"
     *                     ),
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
     *                         "access_token":"example of token",
     *                         "token_type":"bearer",
     *                         "expires_in":"7200",
     *
     *                         "user":{
     *                         "id": 1,
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "email_verified_at": null,
     *                         "created_at": null,
     *                         "updated_at": null
     *                          }
     *                     }
     *                 )
     *             )
     *         }
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
    public function login(LoginRequest $request){

        $login_credentials = $request->all();
        $token = auth()->attempt($login_credentials);
        return $token ? $this->createNewToken($token) : response('Error, incorrect data!', 401);
    }




    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }



    /**
     * @OA\Get(
     * path="/refresh",
     * summary="Path to refresh user's token",
     * description="The way to refresh user's token.",
     * operationId="refresh",
     * tags={"auth"},
     *
     *
     *     @OA\Parameter (
     *      name = "access_token",
     *      in = "query",
     *      description = "Old token of user, who wants new token.",
     *      required=true,
     *         @OA\Schema(
     *           type="string",
     *           format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         description="The token, that user uses to log in"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         description="Type of token"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         description="Time in minutes to token expire"
     *                     ),
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
     *                         "access_token":"example of token",
     *                         "token_type":"bearer",
     *                         "expires_in":"7200",
     *
     *                         "user":{
     *                         "id": 1,
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "email_verified_at": null,
     *                         "created_at": null,
     *                         "updated_at": null
     *                          }
     *                     }
     *                 )
     *             )
     *         }
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

    public function refresh(){
        try{
            $new_token = auth()->refresh();
            return $this->createNewToken($new_token);
        }
        catch (TokenInvalidException $exception) {
            return Response::json(['error' => $exception->getMessage()], 401);
        }
    }



    /**
     * @OA\POST(
     * path="/register",
     * summary="Path to register in system",
     * description="The way to register users.",
     * operationId="register",
     * tags={"auth"},
     *
     *
     *     @OA\RequestBody(
     *         description="The personal information of registered users. In field login user can enter login or email",
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
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="access_token",
     *                         type="string",
     *                         description="The token, that user uses to log in"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="token_type",
     *                         type="string",
     *                         description="Type of token"
     *                     ),
     *
     *                      @OA\Property(
     *                         property="expires_in",
     *                         type="integer",
     *                         description="Time in minutes to token expire"
     *                     ),
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
     *                         "access_token":"example of token",
     *                         "token_type":"bearer",
     *                         "expires_in":"7200",
     *
     *                         "user":{
     *                         "id": 1,
     *                         "name": "Example name",
     *                         "email": "example@mail.com",
     *                         "login": "example_user3457",
     *                         "email_verified_at": null,
     *                         "created_at": null,
     *                         "updated_at": null
     *                          }
     *                     }
     *                 )
     *             )
     *         }
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

    public function register(RegisterRequest $request){
        try{
            User::createNewUser($request->all());
            return $this->createNewToken(auth()->attempt($request->only('login', 'password')));
        }
        catch (\PHPUnit\Exception $exception){
            return Response::json(['error'=>$exception->getMessage()], 401);
        }
    }

}
