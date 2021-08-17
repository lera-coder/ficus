<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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
        Route::post('user/auth2fa/toggle/{activity}', ["App\Http\Controllers\API\UserController", 'toggle2FAAuth']);
        Route::post('user/email/{activity}', ["App\Http\Controllers\API\UserController", 'toggle2FAAuth']);
    });

    //Email verifiing
    Route::get('email/verify', ['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', ['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailConfirm'])->name('verification.verify');
    Route::post('/email/verification-notification',['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailSend'])->middleware(['throttle:6,1'])->name('verification.send');

});


//Auth routes
Route::post('/forgot-password', ['App\Http\Controllers\API\Auth\AuthController', 'emailPassword'])->name('password.email');
Route::post('/reset-password', ['App\Http\Controllers\API\Auth\AuthController', 'resetPassword'])->name('password.reset');
Route::post("/login", ['App\Http\Controllers\API\Auth\AuthController', 'login'])->name('login');
Route::post("/register", ['App\Http\Controllers\API\Auth\AuthController', 'register'])->name('register');
Route::get("/refresh", ['App\Http\Controllers\API\Auth\AuthController', 'refresh'])->name('refresh');
Route::get('/login/{network}/redirect', ['App\Http\Controllers\API\Auth\AuthController', 'redirectToSocialNetwork'])->name('network.redirect');
Route::get('/login/{network}/callback', ['App\Http\Controllers\API\Auth\AuthController', 'callbackFromSocialNetwork'])->name('login.network');
//2auth
Route::post('2auth/token',['App\Http\Controllers\API\Auth\AuthController', 'post2FAToken'])->name('post2auth.token');
