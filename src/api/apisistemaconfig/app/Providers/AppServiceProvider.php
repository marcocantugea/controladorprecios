<?php

namespace App\Providers;

use App\Contractors\Repositories\IMenuRepository;
use App\Contractors\Repositories\IModuloRepository;
use App\Contractors\Services\IAuthService;
use App\Contractors\Services\IMenuService;
use App\Contractors\Services\IModuloService;
use App\Contractors\Wrappers\IAuthWrapper;
use App\Mappers\MenuMapper;
use App\Mappers\ModuloMapper;
use App\Mappers\RolModuloMapper;
use App\Repositories\MenuRepository;
use App\Repositories\ModuloRepository;
use App\Services\AuthService;
use App\Services\MenuService;
use App\Services\ModuloService;
use App\Wrappers\AuthWrapper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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

        $this->app->scoped(MenuMapper::class,function($app){
            return new MenuMapper();
        });

        $this->app->scoped(ModuloMapper::class,function($app){
            return new ModuloMapper();
        });

        $this->app->scoped(IModuloRepository::class,function($app){
            return new ModuloRepository(DB::connection(),$app[ModuloMapper::class],$app[RolModuloMapper::class]);
        });

        $this->app->scoped(IModuloService::class,function($app){
            return new ModuloService($app[IModuloRepository::class],$app[ModuloMapper::class],$app[RolModuloMapper::class]);
        });

        $this->app->scoped(IMenuRepository::class,function($app){
            return new MenuRepository(DB::connection(),$app[MenuMapper::class]);
        });

        $this->app->scoped(IMenuService::class,function($app){
            return new MenuService($app[IMenuRepository::class],$app[MenuMapper::class]);
        });

        $this->app->scoped(RolModuloMapper::class,function($app){
            return new RolModuloMapper();
        });
    }
}
