<?php

use App\Services\SearchService\AllSearchService\AllSearchServiceInterface;
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
    Route::middleware(['verified', 'auth.2fa'])->group(function () {

        //Model Routes
        Route::resource('companies', 'App\Http\Controllers\API\CompanyController')->except('edit', 'create');
        Route::resource('knowledges', 'App\Http\Controllers\API\KnowledgeController')->except('edit', 'create');
        Route::resource('projects', 'App\Http\Controllers\API\ProjectController')->except('edit', 'create');
        Route::resource('interviews', 'App\Http\Controllers\API\InterviewController')->except('edit', 'create');
        Route::resource('country-codes', "App\Http\Controllers\API\PhoneCountryCodeController")->except('edit', 'create');
        Route::resource('applicants', "App\Http\Controllers\API\ApplicantController")->except('edit', 'create');
        Route::resource("users", "App\Http\Controllers\API\UserController")->except('edit', 'create');
        Route::resource('phones', "App\Http\Controllers\API\PhoneController")->except('edit', 'create');
        Route::resource('emails', "App\Http\Controllers\API\EmailController")->except('edit', 'create');
        Route::resource('workers', "App\Http\Controllers\API\WorkerController")->except('edit', 'create');
        Route::resource('technologies', "App\Http\Controllers\API\TechnologyController")->except('edit', 'create');
        Route::resource('roles', "App\Http\Controllers\API\RoleController")->only('index', 'show');
        Route::resource('worker-statuses', "App\Http\Controllers\API\WorkerStatusController")->only('index', 'show');
        Route::resource('applicant-statuses', "App\Http\Controllers\API\ApplicantStatusController")->only('index', 'show');
        Route::resource('project-statuses', "App\Http\Controllers\API\ProjectStatusController")->only('index', 'show');
        Route::resource('levels', "App\Http\Controllers\API\LevelController")->only('index', 'show');
        Route::resource('worker-positions', "App\Http\Controllers\API\WorkerPositionController")->except('edit', 'create');
        Route::resource('worker-emails', "App\Http\Controllers\API\WorkerEmailController")->except('edit', 'create');
        Route::resource('worker-phones', "App\Http\Controllers\API\WorkerPhoneController")->except('edit', 'create');
        Route::resource("users", "App\Http\Controllers\API\UserController")->except('edit', 'create');

//        Route::get('networks', ["App\Http\Controllers\API\NetworkController", "index"])->name('networks');

        //Method to get phones by countries
        Route::get('country-code/phones/{id}', ["App\Http\Controllers\API\PhoneCountryCodeController", "phones"])->name('phones.country');


        //Activate email
        Route::get('users/emails/activate/{id}', ["App\Http\Controllers\API\EmailController", 'setActive']);
        //Get active email
        Route::get("users/emails/active", ["App\Http\Controllers\API\EmailController", "activeEmail"])->name("email.active");

        //Activate phone
        Route::get('users/phones/activate/{id}', ["App\Http\Controllers\API\PhoneController", 'setActive']);
        //Get active phone
        Route::get("users/phones/active", ["App\Http\Controllers\API\PhoneController", "activePhone"])->name("email.active");


        //Toggle 2FA
        Route::get('user/auth2fa/toggle', ["App\Http\Controllers\API\UserController", 'toggle2FAAuth']);


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

        //searching
        Route::get('users/search/{query}', ["App\Http\Controllers\API\UserController", "search"]);
        Route::get('projects/search/{query}', ["App\Http\Controllers\API\ProjectController", "search"]);
        Route::get('search/{query}', function ($query, AllSearchServiceInterface $allSearchService) {
            return $allSearchService->search($query);
        });

    });

    //2auth
    Route::post('2auth/token', ['App\Http\Controllers\API\Auth\AuthController', 'post2FAToken'])->name('post2auth.token');

    //Email verifiing
    Route::get('email/verify', ['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', ['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailConfirm'])->name('verification.verify');
    Route::post('/email/verification-notification', ['App\Http\Controllers\API\Auth\AuthController', 'verifyEmailSend'])->middleware(['throttle:6,1'])->name('verification.send');

});


//Auth routes
Route::post('/forgot-password', ['App\Http\Controllers\API\Auth\AuthController', 'emailPassword'])->name('password.email');
Route::post('/reset-password', ['App\Http\Controllers\API\Auth\AuthController', 'resetPassword'])->name('password.reset');
Route::post("/login", ['App\Http\Controllers\API\Auth\AuthController', 'login'])->name('login');
Route::post("/register", ['App\Http\Controllers\API\Auth\AuthController', 'register'])->name('register');
Route::get("/refresh", ['App\Http\Controllers\API\Auth\AuthController', 'refresh'])->name('refresh');
Route::get('/login/{network}/redirect', ['App\Http\Controllers\API\Auth\AuthController', 'redirectToSocialNetwork'])->name('network.redirect');
Route::get('/login/{network}/callback', ['App\Http\Controllers\API\Auth\AuthController', 'callbackFromSocialNetwork'])->name('login.network');



