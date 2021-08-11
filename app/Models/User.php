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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * Static function for creating new User and firing event of registration
     * @param $credentials
     */
    public static function createNewUser($credentials){
        $credentials['password'] = Hash::make($credentials['password']);
        $user = self::create($credentials);
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
            : ['email' => User::where('login', $login)->first()->email];
    }


    /**
     * Function to edit user, that login via social network and return him a token
     * @param $network_id
     */
    public function updateSocialNetwork($network_id){
        $this->network_id = $network_id;
        $this->email_verified_at = now();
        $this->save();
        return auth()->login($this);
    }

}
