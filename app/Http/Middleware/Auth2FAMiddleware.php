<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth2FAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user->is_2auth && !$user->token2fa->is_confirmed){
            return response()->json(['status' => 'You should confirm your account via 2FA!'], 401);
        }
        return $next($request);


//        try {
//            $user = JWTAuth::parseToken()->authenticate();
//        } catch (Exception $e) {
//            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
//                return response()->json(['status' => 'Token is Invalid'], 401);
//            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
//                return response()->json(['status' => 'Token is Expired'], 401);
//            }else{
//                return response()->json(['status' => 'Authorization Token not found'], 401);
//            }
//        }
//        return $next($request);
    }
}
