<?php

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


Route::middleware('jwt.verify')->group(function () {


    //Routes in Admin Panel
    Route::middleware(['verified','auth.2fa'])->group(function () {

        //Model Routes
        Route::resource('company', 'App\Http\Controllers\API\CompanyController');
        Route::resource('knowledge', 'App\Http\Controllers\API\KnowledgeController');
        Route::resource('project', 'App\Http\Controllers\API\ProjectController');
        Route::resource('interview', 'App\Http\Controllers\API\InterviewController');

        //Methods for country codes
        Route::resource('country-code', "App\Http\Controllers\API\PhoneCountryCodeController")->except('edit', 'create');
        //Method to get phones by countries
        Route::get('country-code/phones/{id}', ["App\Http\Controllers\API\PhoneCountryCodeController", "phones"])->name('phones.country');


        //Activate email
        Route::get('user/email/activate/{id}', ["App\Http\Controllers\API\EmailController", 'setActive']);
        //Get active email
        Route::get("user/email/active", ["App\Http\Controllers\API\EmailController", "activeEmail"])->name("email.active");
        //Methods for email
        Route::resource('user/email', "App\Http\Controllers\API\EmailController")->except('edit', 'create');


        //Activate phone
        Route::get('user/phone/activate/{id}', ["App\Http\Controllers\API\PhoneController", 'setActive']);
        //Get active phone
        Route::get("user/phone/active", ["App\Http\Controllers\API\PhoneController", "activePhone"])->name("email.active");
        //Methods for phone
        Route::resource('user/phone', "App\Http\Controllers\API\PhoneController")->except('edit', 'create');

        //Toggle 2FA
        Route::get('user/auth2fa/toggle', ["App\Http\Controllers\API\UserController", 'toggle2FAAuth']);

        //User methods
        Route::resource("user", "App\Http\Controllers\API\UserController")->except('edit', 'create');

        //Phonebook
        Route::get("phonebook/users", ["App\Http\Controllers\API\PhoneBookController", "users"]);
        Route::get("phonebook/applicants", ["App\Http\Controllers\API\PhoneBookController", "applicants"]);
        Route::get("phonebook/workers", ["App\Http\Controllers\API\PhoneBookController", "workers"]);

        //Check permissions
        Route::get("applicant/permissions/{id}", ["App\Http\Controllers\API\ApplicantController", "permissions"]);
        Route::get("user/permissions/{id}", ["App\Http\Controllers\API\UserController", "permissions"]);
        Route::get("interview/permissions/{id}", ["App\Http\Controllers\API\InterviewController", "permissions"]);

        //filtration for interviews
        Route::get("interviews/filtration", ["App\Http\Controllers\API\InterviewController", "filtration"]);

    });

    //2auth
    Route::post('2auth/token',['App\Http\Controllers\API\Auth\AuthController', 'post2FAToken'])->name('post2auth.token');

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



//Route::get('user-applicant/{id}', function ($id){
//    return new \App\Http\Resources\UserApplicantPermissionResource(\App\Models\UserApplicantPermission::find($id));
//});

