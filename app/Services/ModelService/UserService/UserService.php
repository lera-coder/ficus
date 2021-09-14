<?php


namespace App\Services\ModelService\UserService;


use App\Exceptions\TransactionFailedException;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\NetworkRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\ModelService\EmailService\EmailServiceInterface;
use App\Services\ModelService\Token2FAService\Token2FAServiceInterface;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Nexmo\Laravel\Facade\Nexmo;

class UserService implements UserServiceInterface
{
    protected $user_repository;
    protected $email_repository;
    protected $email_service;
    protected $network_repository;
    protected $token2FA_service;


    public function __construct(UserRepositoryInterface $user_repository,
                                EmailRepositoryInterface $email_repository,
                                EmailServiceInterface $email_service,
                                NetworkRepositoryInterface $network_repository,
                                Token2FAServiceInterface $token2FA_service)
    {

        $this->user_repository = $user_repository;
        $this->email_repository = $email_repository;
        $this->email_service = $email_service;
        $this->network_repository = $network_repository;
        $this->token2FA_service = $token2FA_service;
    }


    public function makeApplicantUser($applicant_data, $request_data)
    {
        //TODO проверка на то, если ли уже у претендента на должность емаил, исключение, добавление
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->user_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->user_repository->getById($id)->destroy();
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function toggle2FA()
    {
        $user = auth()->user();
        $this->checkActivePhoneAvalability($user->id);

        $user->is_2auth = !$user->is_2auth;
        $user->token2fa->is_confirmed = true;
        $user->push();

        return $user->is_2auth;
    }

    /**
     * @param $id
     * @return bool
     */
    protected function checkActivePhoneAvalability($id)
    {
        return (is_null($this->user_repository->activePhone($id)));
    }

    /**
     * @param $token
     * @return bool
     */
    public function check2FAtoken($token)
    {
        $user = auth()->user();
        $right = $token == $this->user_repository->token2fa($user)->token;

        try {
            DB::beginTransaction();
            if ($right) {
                $user->token2fa->is_confirmed = true;
            }
            $this->deleteToken2FAIfUserIsVerified();
            DB::commit();
        } catch (TransactionFailedException $exception) {
            DB::rollBack();
        }
        return $right;
    }

    protected function deleteToken2FAIfUserIsVerified()
    {
        $user = auth()->user();
        $user->token2fa->token = null;
        $user->push();
    }

    public function send2FACode()
    {
        $user = auth()->user();

        Nexmo::message()->send([
            'to' => $this->repository->getFullActivePhone($user),
            'from' => ENV('NEXMO_FROM_NUMBER'),
            'text' => $this->set2FAtoken($user)
        ]);

        $this->markUserAfterSending2FAToken();

    }

    /**
     * @return string
     */
    public function set2FAtoken()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $token = implode(Arr::random([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], 4));
            $token2fa_model = $this->user_repository->token2fa($user);
            $token2fa_model->token = $token;
            $user->push();
            DB::commit();
        } catch (TransactionFailedException $exception) {
            DB::rollBack();
        }
        return $token;
    }


    protected function markUserAfterSending2FAToken()
    {
        $user = auth()->user();
        $user->token2fa->is_confirmed = false;
        $user->push();

    }

    /**
     * @param $network
     * @param $user_credentials
     */
    public function updateUserAfterSocialNetworkLoggedIn($network, $user_credentials)
    {
        $email = $this->email_repository->getModelByEmail($user_credentials->email);

        if ($email) {
            $user = $this->email_repository->user($email);
        } else {
            $this->create($user_credentials);
        }

        try {
            DB::beginTransaction();
            $user->network_id = $this->network_repository->getModelByName($network)->id;
            $this->email_repository->activeEmail($user->id)->email_verified_at = now();
            $user->push();
            DB::commit();
        } catch (TransactionFailedException $exception) {
            DB::rollBack();
        }
        return auth()->login($user);
    }

    /**
     * @param $credentials
     */
    public function create($credentials)
    {

        $user = $this->createUserModelByCredentials($credentials);

        try {
            DB::beginTransaction();
            if (array_key_exists('email', $credentials)) {
                $this->email_service->create(['email' => $credentials['email'], 'user_id' => $user->id]);
            }
            $this->token2FA_service->create($user->id);
            DB::commit();
            event(new Registered($user));
        } catch (TransactionFailedException $exception) {
            DB::rollBack();
        }
    }

    /**
     * @param $credentials
     * @return mixed
     */
    protected function createUserModelByCredentials($credentials)
    {
        return $this->user_repository->model->create($this->modifyArrayOfUserCredentials($credentials));
    }

    /**
     * @param $credentials
     * @return mixed
     */
    protected function modifyArrayOfUserCredentials($credentials)
    {
        if (array_key_exists('password', $credentials)) {
            $credentials['password'] = Hash::make($credentials['password']);
        }
        unset($credentials['email']);
        return $credentials;
    }

    /**
     * @param $login
     * @return mixed
     */
    public function getEmailViaLogin($login)
    {
        return $this->user_repository->getById($this->user_repository->getIdViaLogin($login))->email->email;

    }

    /**
     * @param $reset_password_data
     * @return mixed
     */
    public function returnResetPasswordStatus($reset_password_data)
    {
        $user = auth()->user();

        return Password::reset(
            $reset_password_data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }


}
