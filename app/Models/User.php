<?php

namespace App\Models;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword;
use Srmklive\Authy\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatable;
use Srmklive\Authy\Contracts\Auth\TwoFactor\Authenticatable as TwoFactorAuthenticatableContract;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail, CanResetPassword, TwoFactorAuthenticatableContract
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;


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


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }



    /**
     * Function, that returns network, via whose user is logged in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network(){
        return $this->belongsTo(Network::class);
    }




    /**
     * Function, that returns all phones, that user have
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(Phone::class);
    }



    /**
     * Function, that returns just active phone of this user
     * @return mixed
     */
    public function activePhone(){
        return $this->phones->where('is_active', 1)->first();
    }


    /**
     * Function, that returns all emails of this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails(){
        return $this->hasMany(Email::class);
    }


    /**
     * Function, that returns just active email of this user
     * @return mixed
     */
    public function activeEmail(){
        return $this->emails->where('is_active', 1)->first();
    }

    /**
     * Function, that returns non active emails of this user
     * @return mixed
     */
    public function disactiveEmails(){
        return $this->emails->where('is_active', 0);
    }

    /**
     * Function, that returns non active phones of this user
     * @return mixed
     */
    public function disactivePhones(){
        return $this->phones->where('is_active', 0);
    }


    /**
     * Function, that returns all roles of this user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }




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




}
