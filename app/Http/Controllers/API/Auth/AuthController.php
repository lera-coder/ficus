<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshPasswordEmailRequest;
use App\Http\Requests\RefreshPasswordUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserFullResource;
use App\Models\Email;
use App\Models\Network;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Nexmo\Laravel\Facade\Nexmo;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{


    /**
     * Login function
     *
     * @param LoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request){

        $login_credentials = $request->all();
        $user = auth()->attempt2FA($login_credentials);
        if(!$user) return response('Error, incorrect password!', 401);
        if($user->is_2auth) {

            Nexmo::message()->send([
                'to'   => $user->getFullActivePhone(),
                'from' => ENV('NEXMO_FROM_NUMBER'),
                'text' => $user->set2FAtoken()
            ]);

            return $user;
        }

        $token = auth()->attempt($login_credentials);
        return $this->createNewToken($token);
    }


    /**
     * Function to check if this 2Fa tiken is right and send user his token
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function post2FAToken(Request $request){
        $user = auth()->retrieveByCredentials(["login"=>$request->user["login"], "password"=>"2206"]);

        return $user->check2FAtoken($request->token) ?
            $this->createNewToken(auth()->login($user)) :
            response('Error, incorrect 2FA token!', 401);
    }




    /**
     * Function to show token with other nessecery information
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => new UserFullResource((auth()->user()))
        ]);
    }




    /**
     * Function to refresh token
     *
     * @return \Illuminate\Http\JsonResponse
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
     * Function to register
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
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
