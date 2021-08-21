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
    use HasFactory, Notifiable, CustomTrait;


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







}
