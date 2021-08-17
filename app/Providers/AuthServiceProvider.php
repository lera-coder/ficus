<?php

namespace App\Providers;

use App\Models\Email;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-phone', function (User $user, Phone $phone) {
            return $user->id === $phone->user_id;
        });

        Gate::define('update-email', function (User $user, Email $email) {
            return $user->id === $email->user_id;
        });


    }
}
