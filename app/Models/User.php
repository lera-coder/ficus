<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'login',
        'network_id'
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_options'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function network(){
        return $this->belongsTo(Network::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function token2fa(){
        return $this->hasOne(Token2fa::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(Phone::class);
    }

    public function emails(){
        return $this->hasMany(Email::class);
    }

    public function activeEmail(){
        return $this->emails()->where('is_active', 1)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    /*********Overriding interface methods. It was done for adding authentication via login

    /***
     * @return bool
     */
    public function hasVerifiedEmail(){
        return !is_null($this->activeEmail()->email_verified_at);
    }


    /***
     * @return bool
     */
    public function markEmailAsVerified(){
        $email = $this->activeEmail();
        $email->email_verified_at = now();
        $email->save();
    }


    /***
     * @return bool
     */
    public function getEmailForVerification()
    {
        return $this->activeEmail()->email;
    }

    /***
     * @return bool
     */
    public function getEmailForPasswordReset(){
        return $this->activeEmail()->email;
    }


    /***
     * @param $notification
     * @return mixed
     */
    public function routeNotificationForMail($notification)
    {
        return $this->activeEmail()->email;
    }


    /****Overriding interface of JWT
    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
