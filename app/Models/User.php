<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * @SWG\Definition(
     *  definition="User",
     *  @SWG\Property(
     *      property="id",
     *      type="integer"
     *  ),
     *  @SWG\Property(
     *      property="name",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="email",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="password",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="login",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="email_verified_at",
     *      type="timestamps"
     *  ),
     *  @SWG\Property(
     *      property="remember_token",
     *      type="string"
     *  ),
     *  @SWG\Property(
     *      property="updated_at",
     *      type="timestamps"
     *  ),
     *  @SWG\Property(
     *      property="created_at",
     *      type="timestamps"
     *  ),
     * )
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'login'
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

    public static function createNewUser($credentials){
        $credentials['password'] = Hash::make($credentials['password']);
        self::create($credentials);
    }

}
