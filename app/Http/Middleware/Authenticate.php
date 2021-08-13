<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.'
        );
    }
//    protected function redirectTo($request)
//    {
////        return response(['Maintenance'], 503);
//
////        return response('You must be!', 401);
//        if (! $request->expectsJson()) {
//            return response(['You should log in firstly!'], 401, ['Accept'=>'application/json']);
//        }
//    }
}
