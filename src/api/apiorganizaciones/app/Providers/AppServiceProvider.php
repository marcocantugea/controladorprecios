<?php

namespace App\Providers;

use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuthWrapper;
use App\Repositories\OrganizacionRepository;
use App\Services\OrganizacionService;
use Illuminate\Support\ServiceProvider;
use App\Mappers\OrganizacionMapper;
use App\Services\AuthService;
use App\Wrappers\AuthWrapper;

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

        $this->app->scoped(OrganizacionMapper::class,function($app){
            return new OrganizacionMapper();
        });

        $this->app->scoped(OrganizacionRepository::class,function($app){
            return new OrganizacionRepository();
        });

        $this->app->scoped(OrganizacionService::class,function($app){
            return new OrganizacionService($app[OrganizacionRepository::class],$app[OrganizacionMapper::class]);
        });
    }
}
