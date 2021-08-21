<?php


namespace App\Services\ModelService\UserService;


use App\Models\Email;
use App\Models\Token2fa;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected  $repository;


    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function create($credentials)
    {
        $user = User::create([
            'name'=>$credentials['name'],
            'login'=>$credentials['login'],
            'password'=>Hash::make($credentials['password'])
        ]);

        $this->createEmailForUser($credentials['email'], $user->id);
        $this->createTokenForUser( $user->id);

        event(new Registered($user));
    }


    protected function createEmailForUser($email, $user_id){
        Email::create([
            'email'=>$email,
            'user_id'=>$user_id,
            'is_active'=>true
        ]);
    }


    protected function createTokenForUser($user_id){
        Token2fa::create([
            'user_id'=>$user_id
        ]);
    }

    public function update($id, $data){
        return $user = $this->repository->getById($id)->update($data);
    }

    public function destroy($id){
        return $this->repository->getById($id)->destroy();
    }



    public function toggle2FA($id)
    {
        $user = $this->repository->getById($id);

        $this->checkActivePhoneAvalability($id);
        $this->changeToken2FA($user);

        return $user->is_2auth ?
            response('2Factor Authentication was successfully turned on'):
            response('2Factor Authentication was successfully turned off');
    }



    protected function checkActivePhoneAvalability($id){
        if(is_null($this->repository->activePhone($id))) return response('You have no phone numbers, please add one, then try again!', 422);
    }


    protected function changeToken2FA(User $user){
        $user->is_2auth = !$user->is_2auth;
        $user->token2fa->is_confirmed = true;
        $user->push();
    }


    public function check2FAtoken($token, $id)
    {
        $user = $this->repository->getById($id);
        $right =  $token == $user->token2fa->token;
        if($right){
            $user->token2fa->is_confirmed = true;
        }
        $user->token2fa->token = null;
        $user->push();
        return $right;
    }


    public function set2FAtoken($id)
    {
        $token = $this->generate2FAtoken();
        $token2fa_model = $this->repository->token2fa($id);
        $token2fa_model->token = $token;
        $this->save();

        return $token;
    }


    protected function generate2FAtoken(){
        $permitted_chars = '0123456789';
        $token ='';

        for($i = 0; $i< 4; $i++){
            $token .= $permitted_chars[rand(0,strlen($permitted_chars) - 1)];
        }

        return $token;
    }

    public function updateUserAfterSocialNetworkLoggedIn($network_id, $user_id)
    {
        $user = $this->repository->getById($user_id);
        $user->network_id = $network_id;
        $user->activeEmail()->email_verified_at = now();
        $user->push();
        return auth()->login($user);
    }

    public function getEmailViaLogin($login)
    {
        return $this->repository->getById($this->repository->getIdViaLogin($login))->email->email;

    }
}
