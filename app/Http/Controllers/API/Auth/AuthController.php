<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshPasswordEmailRequest;
use App\Http\Requests\RefreshPasswordUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Email;
use App\Models\Network;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Srmklive\Authy\Facades\Authy;
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
            'user' => new UserResource((auth()->user()))
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

    public function register(RegisterRequest  $request){
        try{
            User::createNewUser($request->all());
            $token = auth()->attempt($request->only('login', 'password'));
            return $this->createNewToken($token);
        }
        catch (\PHPUnit\Exception $exception){
            return Response::json(['error'=>$exception->getMessage()], 401);
        }
    }


    /**
     * Function to check data to decide is those data valid
     *
     * @param RefreshPasswordEmailRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function emailPassword(RefreshPasswordEmailRequest $request){
        $status = Password::sendResetLink($request->only('login'));
        return $status === Password::RESET_LINK_SENT
            ? response('Now user should go to confirm email')
            :response('Sorry, you cannot change your password!', 401);
    }


    /**
     * Function to reset password after confirmation on email
     *
     * @param RefreshPasswordUpdateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPassword(RefreshPasswordUpdateRequest $request){

        $status = Password::reset(
            $request->only('password', 'password_confirmation', 'token', 'email'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response('Everything is good')
            : response('Something went wrong!', 500);
    }


    /**
     * The function to redirect user to network to authentificate
     *
     * @param $network
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function redirectToSocialNetwork($network){
        if (!Network::checkForExist($network)) return response("Sorry, network ".$network." is not used by our app.", 404);
        return Socialite::driver($network)->stateless()->redirect();
    }




    /**
     * Function to add or login user in system via data retrieved from network
     * @param $network
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */

    public function callbackFromSocialNetwork($network){
        $network_id = Network::checkForExist($network);
        if (!$network_id){
            return response("Sorry, network " . $network . " is not used by our app.", 404);
        }

        $network_id = $network_id->id;

        $user_credentials = Socialite::driver($network)->stateless()->user();
        $user = Email::where('email', $user_credentials->email)->first()->user;

        if(!$user){
            $user = User::create([
                'name' => $user_credentials->name,
                'email' => $user_credentials->email,
            ]);
        }

        return $this->createNewToken($user->updateSocialNetwork($network_id));


    }





    /**
     * Send the post-authentication response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, Authenticatable $user)
    {
        if (Authy::getProvider()->isEnabled($user)) {
            return $this->logoutAndRedirectToTokenScreen($request, $user);
        }

        return redirect()->intended($this->redirectPath());
    }


    /**
     * Generate a redirect response to the two-factor token screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Http\Response
     */
    protected function logoutAndRedirectToTokenScreen(Request $request, Authenticatable $user)
    {
        auth($this->getGuard())->logout();
        $request->session()->put('authy:auth:id', $user->id);

        return redirect(url('auth/token'));
    }



    /**
     * Verify the two-factor authentication token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post2AuthToken(Request $request)
    {
        $this->validate($request, ['token' => 'required']);
        if (! session('authy:auth:id')) {
            return redirect(url('login'));
        }

        $guard = config('auth.defaults.guard');
        $provider = config('auth.guards.' . $guard . '.provider');
        $model = config('auth.providers.' . $provider . '.model');
        $user = (new $model)->findOrFail(
            $request->session()->pull('authy:auth:id')
        );

        if (Authy::getProvider()->tokenIsValid($user, $request->token)) {
            auth($this->getGuard())->login($user);
            return redirect()->intended($this->redirectPath());
        } else {
            return redirect(url('login'))->withErrors('Invalid two-factor authentication token provided!');
        }
    }


    /**
     * Route to show, that user must firstly verify email to use get the wishful result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmailNotice(){
        return Response::json(['Please, verify your email, firstly!'], 401);
    }


    /**
     * Route to send the list with email verifiing button second time
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmailSend(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return Response::json(['Email was successfully sended']);
    }


    /**
     * Route to mark in database, that user verified password
     *
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmailConfirm(EmailVerificationRequest $request){
        $request->fulfill();
        return Response::json(['Your email is verified']);
    }




}
