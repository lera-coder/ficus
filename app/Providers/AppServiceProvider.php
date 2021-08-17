<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('required_if_not_empty', function($attribute, $value, $parameters, $validator) {
            $other = array_get($validator->getData(), $parameters[0], null);

            if (!empty($other)) {
                return $validator->validateRequired($attribute, $value);
            }

            return true;
        });
    }
}
