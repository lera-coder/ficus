<?php


namespace App\Repositories\Interfaces;


use App\Models\Token2fa;

interface Token2FARepositoryInterface extends RepositoryInterface
{
    public static function user(Token2fa $token2FA);

}
