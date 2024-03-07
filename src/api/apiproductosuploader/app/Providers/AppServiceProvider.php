<?php

namespace App\Providers;

use App\Interfaces\Services\IAuthService;
use App\Services\AuthService;
use App\Wrappers\AuthWrapper;
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
        $this->app->scoped(AuthWrapper::class,function($app){
            return new AuthWrapper();
        });

        $this->app->scoped(AuthService::class,function($app){
            return new AuthService($app[AuthWrapper::class]);
        });
    }
}
