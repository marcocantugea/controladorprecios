<?php

namespace App\Providers;

use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuthWrapper;
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
        $this->app->scoped(IAuthWrapper::class,function($app){
            return new AuthWrapper();
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IAuthWrapper::class]);
        });
    }
}
