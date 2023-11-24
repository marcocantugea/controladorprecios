<?php

namespace App\Providers;

use App\Contractors\Repositories\ICanalesVentaRepository;
use App\Contractors\Repositories\ICanalVentaListaPrecioRepository;
use App\Contractors\Services\IAuthService;
use App\Contractors\Services\ICanalesVentaService;
use App\Contractors\Services\ICanalVentaListaPrecioService;
use App\Contractors\Services\IListaPreciosService;
use App\Contractors\Services\IProductoService;
use App\Contractors\Services\IProductosService;
use App\Contractors\Wrappers\IAuth;
use App\Contractors\Wrappers\IListaPreciosWrapper;
use App\Contractors\Wrappers\IProductoWrapper;
use App\Mappers\CanalesVentaMapper;
use App\Mappers\CanalVentaListaPrecioMapper;
use App\Repositories\CanalesVentaRepository;
use App\Repositories\CanalVentaListaPrecioRepository;
use App\Services\AuthService;
use App\Services\CanalesVentaService;
use App\Services\CanalVentaListaPreciosService;
use App\Services\ListaPreciosService;
use App\Services\ProductoService;
use App\Wrappers\Auth;
use App\Wrappers\ListaPreciosWrapper;
use App\Wrappers\ProductoWrapper;
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
        $this->app->scoped(IAuth::class,function($app){
            return new Auth();
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IAuth::class]);
        });

        $this->app->scoped(CanalesVentaMapper::class,function($app){
            return new CanalesVentaMapper();
        });

        $this->app->scoped(ICanalesVentaRepository::class,function($app){
            return new CanalesVentaRepository(DB::connection(),$app[CanalesVentaMapper::class]);
        });

        $this->app->scoped(ICanalesVentaService::class,function($app){
            return new CanalesVentaService($app[ICanalesVentaRepository::class],$app[CanalesVentaMapper::class]);
        });

        $this->app->scoped(CanalVentaListaPrecioMapper::class,function($app){
            return new CanalVentaListaPrecioMapper();
        });

        $this->app->scoped(ICanalVentaListaPrecioRepository::class,function($app){
            return new CanalVentaListaPrecioRepository(DB::connection(),$app[CanalVentaListaPrecioMapper::class],$app[CanalesVentaMapper::class]);
        });

        $this->app->scoped(ICanalVentaListaPrecioService::class,function($app){
            return new CanalVentaListaPreciosService($app[ICanalVentaListaPrecioRepository::class],$app[CanalVentaListaPrecioMapper::class],$app[CanalesVentaMapper::class],$app[IListaPreciosService::class],$app[IProductoService::class]);
        });

        $this->app->scoped(IListaPreciosWrapper::class,function($app){
            return new ListaPreciosWrapper();
        });

        $this->app->scoped(IListaPreciosService::class,function($app){
            return new ListaPreciosService($app[IListaPreciosWrapper::class]);
        });

        $this->app->scoped(IProductoWrapper::class,function($app){
            return new ProductoWrapper();
        });

        $this->app->scoped(IProductoService::class,function($app){
            return new ProductoService($app[IProductoWrapper::class]);
        });
    }
}
