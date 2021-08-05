<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('jwt.verify, auth')->group(function () {
    Route::resource("user", "App\Http\Controllers\API\UserController")->except('edit', 'create');
});

Route::post("/login", ['App\Http\Controllers\API\Auth\AuthController', 'login'])->name('login');
Route::post("/register", ['App\Http\Controllers\API\Auth\AuthController', 'register'])->name('register');
Route::get("/refresh", ['App\Http\Controllers\API\Auth\AuthController', 'refresh'])->name('refresh');
