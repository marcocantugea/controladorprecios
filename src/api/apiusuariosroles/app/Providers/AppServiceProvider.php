<?php

namespace App\Providers;

use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IAuthService;
use App\Contractors\Services\IUsuariosService;
use App\Mappers\UsuarioMapper;
use App\Repositories\UsuariosRepository;
use App\Services\AuthService;
use App\Services\UsuariosService;
use Illuminate\Support\Facades\DB;
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
        $this->app->scoped(UsuarioMapper::class,function($app){
            return new UsuarioMapper();
        });

        $this->app->scoped(IUsuariosRepository::class,function($app){
            return new UsuariosRepository(DB::connection());
        });

        $this->app->scoped(IUsuariosService::class,function($app){
            return new UsuariosService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });
    }
}
