<?php

namespace App\Providers;

use App\Contractors\Repositories\IAccionesRepository;
use App\Contractors\Repositories\IRolAccionRepository;
use App\Contractors\Repositories\IRolesRepository;
use App\Contractors\Repositories\IRolUsuarioRepository;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IAccionesService;
use App\Contractors\Services\IAuthService;
use App\Contractors\Services\IRolAccionService;
use App\Contractors\Services\IRolService;
use App\Contractors\Services\IRolUsuarioService;
use App\Contractors\Services\IUsuariosService;
use App\Mappers\AccionMapper;
use App\Mappers\RolAccionMapper;
use App\Mappers\RolMapper;
use App\Mappers\RolUsuarioMapper;
use App\Mappers\UsuarioMapper;
use App\Repositories\AccionesRepository;
use App\Repositories\RolAccionRepository;
use App\Repositories\RolesRepository;
use App\Repositories\RolUsuarioRepository;
use App\Repositories\UsuariosRepository;
use App\Services\AccionesService;
use App\Services\AuthService;
use App\Services\RolAccionesService;
use App\Services\RolService;
use App\Services\RolUsuarioService;
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
            return new UsuariosRepository(DB::connection(),$app[RolMapper::class]);
        });

        $this->app->scoped(IUsuariosService::class,function($app){
            return new UsuariosService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });

        $this->app->scoped(RolMapper::class,function($app){
            return new RolMapper();
        });

        $this->app->scoped(IRolesRepository::class,function($app){
            return new RolesRepository(DB::connection(),$app[RolMapper::class]);
        });

        $this->app->scoped(IRolService::class,function($app){
            return new RolService($app[IRolesRepository::class],$app[RolMapper::class]);
        });

        $this->app->scoped(AccionMapper::class,function($app){
            return new AccionMapper();
        });

        $this->app->scoped(IAccionesRepository::class,function($app){
            return new AccionesRepository(DB::connection(),$app[AccionMapper::class]);
        });

        $this->app->scoped(IAccionesService::class,function($app){
            return new AccionesService($app[IAccionesRepository::class],$app[AccionMapper::class]);
        });

        $this->app->scoped(RolAccionMapper::class,function($app){
            return new RolAccionMapper();
        });

        $this->app->scoped(IRolAccionRepository::class,function($app){
            return new RolAccionRepository(DB::connection(),$app[RolAccionMapper::class]);
        });

        $this->app->scoped(IRolAccionService::class,function($app){
            return new RolAccionesService($app[IRolAccionRepository::class],$app[RolAccionMapper::class],$app[IAccionesService::class]);
        });

        $this->app->scoped(RolUsuarioMapper::class,function($app){
            return new RolUsuarioMapper();
        });

        $this->app->scoped(IRolUsuarioRepository::class,function($app){
            return new RolUsuarioRepository(DB::connection(),$app[RolUsuarioMapper::class]);
        });

        $this->app->scoped(IRolUsuarioService::class,function($app){
            return new RolUsuarioService($app[IRolUsuarioRepository::class],$app[RolUsuarioMapper::class],$app[IUsuariosRepository::class],$app[IRolesRepository::class]);
        });
    }
}
