<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('jwt.verify')->group(function () {

    //Routes in Admin Panel
    Route::middleware('verified')->group(function () {
        Route::resource("user", "App\Http\Controllers\API\UserController")->except('edit', 'create');
    });

    //Password reset
//    Route::post('/forgot-password', function (Request $request) {
//        $request->validate(['email' => 'required|email']);
//
//        $status = Password::sendResetLink(
//            $request->only('email')
//        );
//
//        return $status === Password::RESET_LINK_SENT
//            ? back()->with(['status' => __($status)])
//            : back()->withErrors(['email' => __($status)]);
//    })->name('password.email');
//
//
//    Route::post('/reset-password', function (Request $request) {
//        $request->validate([
//            'token' => 'required',
//            'email' => 'required|email',
//            'password' => 'required|min:8|confirmed',
//        ]);
//
//        $status = Password::reset(
//            $request->only('email', 'password', 'password_confirmation', 'token'),
//            function ($user, $password) use ($request) {
//                $user->forceFill([
//                    'password' => Hash::make($password)
//                ])->setRememberToken(Str::random(60));
//
//                $user->save();
//
//                event(new PasswordReset($user));
//            }
//        );
//
//        return $status == Password::PASSWORD_RESET
//            ? redirect()->route('login')->with('status', __($status))
//            : back()->withErrors(['email' => [__($status)]]);
//    })->name('password.update');




    //Email verifiing
    Route::get('email/verify', function(){
        return response()->toJson(['Please, verify your email, firstly!'], 401);
    });

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('user.index');
    })->name('verification.verify');


    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');


});


//Auth routes
Route::post('/forgot-password', ['App\Http\Controllers\API\Auth\AuthController', 'emailPassword'])->name('password.email');
Route::post('/reset-password', ['App\Http\Controllers\API\Auth\AuthController', 'resetPassword'])->name('password.reset');
Route::post("/login", ['App\Http\Controllers\API\Auth\AuthController', 'login'])->name('login');
Route::post("/register", ['App\Http\Controllers\API\Auth\AuthController', 'register'])->name('register');
Route::get("/refresh", ['App\Http\Controllers\API\Auth\AuthController', 'refresh'])->name('refresh');
Route::get('/login/{network}/redirect', ['App\Http\Controllers\API\Auth\AuthController', 'redirectToSocialNetwork'])->name('network.redirect');
Route::get('/login/{network}/callback', ['App\Http\Controllers\API\Auth\AuthController', 'callbackFromSocialNetwork'])->name('login.network');


