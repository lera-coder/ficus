<?php

namespace App\Models;

use App\CustomTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Traits\UserTrait;



class User extends Authenticatable implements JWTSubject, MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable, CustomTrait, UserTrait;


    protected $fillable = [
        'name',
        'email',
        'password',
        'login',
        'network_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_options'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





/**********************************JWT-interface overriding****************************/




    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }





/**********************************Eloquent relationships****************************/



    /**
     * Function, that returns network, via whose user is logged in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network(){
        return $this->belongsTo(Network::class);
    }


    /**
     * Function, that returns 2FAtoken
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function token2fa(){
        return $this->hasOne(Token2fa::class);
    }



    /**
     * Function, that returns all phones, that user have
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(Phone::class);
    }



    /**
     * Function, that returns all emails of this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails(){
        return $this->hasMany(Email::class);
    }


    /**
     * Function, that returns all roles of this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }





    /**********************************Authentication specials****************************/
    /***********Simple Authentication


    /**
     * Static function for creating new User and firing event of registration
     * @param $credentials
     */
    public static function createNewUser($credentials){
        $credentials_edited = $credentials;
        unset($credentials_edited['email']);
        $credentials_edited['password'] = Hash::make($credentials_edited['password']);

        $user = self::create($credentials_edited);

        Email::create([
            'email'=>$credentials['email'],
            'user_id'=>$user->id,
            'is_active'=>true
        ]);

        Token2fa::create([
            'user_id'=>$user->id
        ]);


        event(new Registered($user));
    }


    /**
     * Static function to get email from login field even, if user entered login
     * @param $login
     * @return array
     */
    public static function getEmail($login){
        return str_contains($login, '@')
            ? ['email' => $login]
            : ['email' => Email::where('email', $login)->first()->email];
    }



    /****************Authentication via Social Networks


    /**
     * Function to edit user, that login via social network and return him a token
     * @param $network_id
     */
    public function updateSocialNetwork($network_id){
        $this->network_id = $network_id;
        $this->activeEmail()->email_verified_at = now();
        $this->save();
        return auth()->login($this);
    }



    /****************Overriding email verification and reset password

    /**
     * Realize method of MustVerifyMail to check is it verified or no
     *
     * @return bool
     */
    public function hasVerifiedEmail(){
        return !is_null($this->activeEmail()->email_verified_at);
    }


    /**
     * Realize method of MustVerifyMail to mark email as verified
     *
     * @return bool
     */
    public function markEmailAsVerified(){
        $email = $this->activeEmail();
        $email->email_verified_at = now();
        $email->save();
    }


    /**
     * Realize method of MustVerifyMail to retrieve email
     *
     * @return bool
     */
    public function getEmailForVerification()
    {
        return $this->activeEmail()->email;
    }

    /**
     * Realize method of CanResetPassword to retrieve email
     *
     * @return bool
     */
    public function getEmailForPasswordReset(){
        return $this->activeEmail()->email;
    }



    /**
     * Get the route of mail
     *
     * @param $notification
     * @return mixed
     */
    public function routeNotificationForMail($notification)
    {
        return $this->activeEmail()->email;
    }


       /**********Authentication via Social Networks

        /**
        * Function for creating anf setting 2FAtoken to database
         * @return string
         */
        public function set2FAtoken(){
        $permitted_chars = '0123456789';
        $token ='';

        for($i = 0; $i< 4; $i++){
            $token .= $permitted_chars[rand(0,strlen($permitted_chars) - 1)];
        }

        $this->token2fa->token = $token;
        $this->push();
        return $token;
    }


    /**
     * Check if user entered the 2fa token rightly
     *
     * @param $token
     * @return bool
     */
    public function check2FAtoken($token){
        $right =  $token == $this->token2fa->token;
        if($right){
            $this->token2fa->is_confirmed = true;
        }
        $this->token2fa->token = null;
        $this->push();
        return $right;

    }


    /**
     * Toggle the 2FA
     */
    public function toggle2FA(){

        if(is_null($this->activePhone())) return response('You have no phone numbers, please add one, then try again!', 422);

        $this->is_2auth = !$this->is_2auth;
        $this->token2fa->is_confirmed = true;
        $this->push();

        return $this->is_2auth ?
            response('2Factor Authentication was successfully turned on'):
            response('2Factor Authentication was successfully turned off');

    }




}
