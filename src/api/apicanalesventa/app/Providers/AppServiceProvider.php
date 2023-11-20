<?php

namespace App\Providers;

use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuth;
use App\Services\AuthService;
use App\Wrappers\Auth;
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
        $this->app->scoped(IAuth::class,function($app){
            return new Auth();
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IAuth::class]);
        });
    }
}
