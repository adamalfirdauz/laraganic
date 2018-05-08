<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Passport::tokensCan([
            'login-admin' => 'Login as admin on Admin Panel or Dashboard',
            'user-detail' => 'Read user detail',
            'make-transaction'=>'Make transaction',
            'access-wallet'=>'Access wallet'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
