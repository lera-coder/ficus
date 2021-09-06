<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\AuthRequests\RefreshPasswordEmailRequest;
use App\Http\Requests\AuthRequests\RefreshPasswordUpdateRequest;
use App\Http\Requests\AuthRequests\RegisterRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\NetworkService\NetworkServiceInterface;
use App\Services\ModelService\UserService\UserServiceInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    protected $user_repository;
    protected $user_service;
    protected $network_service;

    public function __construct(UserRepositoryInterface $user_repository,
                                UserServiceInterface $user_service,
                                NetworkServiceInterface $network_service)
    {
        $this->user_repository = $user_repository;
        $this->user_service = $user_service;
        $this->network_service = $network_service;
    }


    /**
     * @param LoginRequest $request
     * @return Application|ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        $login_credentials = $request->all();
        $user = auth()->attempt2FA($login_credentials);
        if (!$user) return response('Error, incorrect password!', 401);
        if ($user->is_2auth) {
            $this->user_service->send2FACode(auth()->user());
        }
        $token = auth()->attempt($login_credentials);
        return $this->createNewToken($token);
    }

    /**
     * Function to show token with other nessecery information
     * @param $token
     * @return JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 1440,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function post2FAToken(Request $request)
    {
        return $this->user_service->check2FAtoken($request->token, auth()->user()) ?
            response('Your personality was successfully verified via 2FA!') :
            response('Error, incorrect 2FA token!', 401);
    }

    /**
     * Function to refresh token
     *
     * @return JsonResponse
     */

    public function refresh()
    {
        try {
            $new_token = auth()->refresh();
            return $this->createNewToken($new_token);
        } catch (TokenInvalidException $exception) {
            return Response::json(['error' => $exception->getMessage()], 401);
        }
    }


    /**
     * Function to register
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $this->user_service->create($request->all());
            return $this->createNewToken(auth()->attempt($request->only('login', 'password')));
        } catch (Exception $exception) {
            return Response::json(['error' => $exception->getMessage()], 401);
        }
    }


    /**
     * Function to check data to decide is those data valid
     *
     * @param RefreshPasswordEmailRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function emailPassword(RefreshPasswordEmailRequest $request)
    {
        $status = Password::sendResetLink($request->only('login'));
        return $status === Password::RESET_LINK_SENT
            ? response('Now user should go to confirm email')
            : response('Sorry, you cannot change your password!', 401);
    }


    /**
     * Function to reset password after confirmation on email
     *
     * @param RefreshPasswordUpdateRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function resetPassword(RefreshPasswordUpdateRequest $request)
    {

        $status = $this->user_service->returnResetPasswordStatus(
            $request->only('password', 'password_confirmation', 'token', 'email'));

        return $status === Password::PASSWORD_RESET
            ? response('Everything is good')
            : response('Something went wrong!', 500);
    }


    /***
     * @param $network
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function redirectToSocialNetwork($network)
    {
        $this->network_service->checkNetworkExistance($network);
        return Socialite::driver($network)->stateless()->redirect();
    }


    /**
     * @param $network
     * @return Application|ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function callbackFromSocialNetwork($network)
    {
        $this->network_service->checkNetworkExistance($network);
        $token = $this->user_service->updateUserAfterSocialNetworkLoggedIn($network, Socialite::driver($network)->stateless()->user());
        return $this->createNewToken($token);

    }


    /***
     * @return JsonResponse
     */
    public function verifyEmailNotice()
    {
        return Response::json(['Please, verify your email, firstly!'], 401);
    }


    /***
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyEmailSend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return Response::json(['Email was successfully sended']);
    }


    /***
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyEmailConfirm(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return Response::json(['Your email is verified']);
    }


}
