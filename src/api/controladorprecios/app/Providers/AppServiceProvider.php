<?php

namespace App\Providers;

use App\Contractors\IMapper;
use App\Contractors\Models\Equivalencia;
use App\Contractors\Models\ProveedorMarca;
use App\Contractors\Repositories\IAtributoRepository;
use App\Contractors\Repositories\ICategoriaRepository;
use App\Contractors\Repositories\ICostosRepository;
use App\Contractors\Repositories\IEquivalenciasRepository;
use App\Contractors\Repositories\IListaPreciosProductoRepository;
use App\Contractors\Repositories\IListaPreciosRepository;
use App\Contractors\Repositories\IMarcaRepository;
use App\Contractors\Repositories\IProductoOrganizacionRepository;
use App\Contractors\Repositories\IProductosRepository;
use App\Contractors\Repositories\IProveedorRepository;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IAtributosService;
use App\Contractors\Services\IAuthService;
use App\Contractors\Services\ICategoriaService;
use App\Contractors\Services\ICostosService;
use App\Contractors\Services\IEquivalenciasService;
use App\Contractors\Services\IListaPreciosProductoService;
use App\Contractors\Services\IListaPreciosService;
use App\Contractors\Services\IMarcasService;
use App\Contractors\Services\IProductoOrganizacion;
use App\Contractors\Services\IProductosService;
use App\Contractors\Services\IProveedoresService;
use App\Contractors\Services\IUsuariosService;
use App\Contractors\Wrappers\IOrganizacionWrapper;
use App\Mappers\AtributoMapper;
use App\Mappers\CategoriaMapper;
use App\Mappers\CostoMapper;
use App\Mappers\EquivalenciaMapper;
use App\Mappers\ListaPreciosMapper;
use App\Mappers\ListaPreciosProductoMapper;
use App\Mappers\MarcaMapper;
use App\Mappers\ProductoMapper;
use App\Mappers\ProductoOrganizacionMapper;
use App\Mappers\ProveedorInfoBasicMapper;
use App\Mappers\ProveedorMapper;
use App\Mappers\ProveedorMarcaMapper;
use App\Mappers\ProveedorProductoMapper;
use App\Mappers\UsuarioMapper;
use App\Repositories\AtributosRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\CostosRepository;
use App\Repositories\EquivalenciasRepository;
use App\Repositories\ListaPreciosProductoRepository;
use App\Repositories\ListaPreciosRepository;
use App\Repositories\MarcasRepository;
use App\Repositories\ProductoOrganizacionRepository;
use App\Repositories\ProductosRepository;
use App\Repositories\ProveedoresRepository;
use App\Repositories\UsuariosRepository;
use App\Services\AtributosService;
use App\Services\AuthService;
use App\Services\CategoriaService;
use App\Services\CostosService;
use App\Services\EquivalenciasService;
use App\Services\ListaPreciosProductoService;
use App\Services\ListaPreciosService;
use App\Services\MarcasService;
use App\Services\ProductoOrganizacion;
use App\Services\ProductoService;
use App\Services\ProveedoresService;
use App\Services\UsuariosService;
use App\Wrappers\OrganizacionWrapper;
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
        $this->app->scoped(ProveedorMapper::class,function($app){
            return new ProveedorMapper();
        });

        $this->app->scoped(ProveedorInfoBasicMapper::class,function($app){
            return new ProveedorInfoBasicMapper();
        });

        $this->app->scoped(ProveedorMarcaMapper::class,function($app){
            return new ProveedorMarcaMapper();
        });

        $this->app->scoped(ProveedorProductoMapper::class,function($app){
            return new ProveedorProductoMapper();
        });

        $this->app->scoped(IProveedorRepository::class,function($app){
            return new ProveedoresRepository(DB::connection());
        });

        $this->app->scoped(IProveedoresService::class,function($app){
            return new ProveedoresService($app[IProveedorRepository::class],
            $app[ProveedorMapper::class],
            $app[ProveedorInfoBasicMapper::class],
            $app[ProveedorMarcaMapper::class],
            $app[IMarcaRepository::class],
            $app[IProductosRepository::class],
            $app[ProveedorProductoMapper::class],
            $app[ProductoMapper::class]
            );
        });

        $this->app->scoped(MarcaMapper::class,function($app){
            return new MarcaMapper();
        });

        $this->app->scoped(IMarcaRepository::class,function($app){
            return new MarcasRepository(DB::connection());
        });

        $this->app->scoped(IMarcasService::class,function($app){
            return new MarcasService($app[IMarcaRepository::class],$app[MarcaMapper::class]);
        });

        $this->app->scoped(UsuarioMapper::class,function($app){
            return new UsuarioMapper();
        });

        $this->app->scoped(IUsuariosRepository::class,function($app){
            return new UsuariosRepository(DB::connection('users'));
        });

        $this->app->scoped(IUsuariosService::class,function($app){
            return new UsuariosService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });

        $this->app->scoped(IAuthService::class,function($app){
            return new AuthService($app[IUsuariosRepository::class],$app[UsuarioMapper::class]);
        });

        $this->app->scoped(ICategoriaRepository::class,function($app){
            return new CategoriaRepository(DB::connection());
        });

        $this->app->scoped(ICategoriaService::class,function($app){
            return new CategoriaService($app[ICategoriaRepository::class],$app[CategoriaMapper::class]);
        });

        $this->app->scoped(AtributoMapper::class,function($app){
            return new AtributoMapper();
        });

        $this->app->scoped(IAtributoRepository::class,function($app){
            return new AtributosRepository(DB::connection());
        });

        $this->app->scoped(IAtributosService::class,function($app){
            return new AtributosService($app[IAtributoRepository::class],$app[AtributoMapper::class]);
        });

        $this->app->scoped(EquivalenciaMapper::class,function($app){
            return new EquivalenciaMapper();
        });

        $this->app->scoped(IEquivalenciasRepository::class,function($app){
            return new EquivalenciasRepository(DB::connection());
        });

        $this->app->scoped(IEquivalenciasService::class,function($app){
            return new EquivalenciasService($app[IProductosRepository::class],$app[IEquivalenciasRepository::class],$app[EquivalenciaMapper::class]);
        });

        $this->app->scoped(CostoMapper::class,function($app){
            return new CostoMapper();
        });

        $this->app->scoped(ICostosRepository::class,function($app){
            return new CostosRepository(DB::connection());
        });

        $this->app->scoped(ICostosService::class,function($app){
            return new CostosService($app[ICostosRepository::class],$app[CostoMapper::class],$app[IProveedorRepository::class],$app[IProductosRepository::class]);
        });

        $this->app->scoped(ProveedorMapper::class,function($app){
            return new ProveedorMapper();
        });

        $this->app->scoped(ProveedorProductoMapper::class,function($app){
            return new ProveedorProductoMapper();
        });

        $this->app->scoped(IProveedorRepository::class,function($app){
            return new ProveedoresRepository(DB::connection());
        });

        $this->app->scoped(CategoriaMapper::class,function($app){
            return new CategoriaMapper();
        });

        $this->app->scoped(ProductoMapper::class,function($app){
            return new ProductoMapper();
        });

        $this->app->scoped(IProductosRepository::class,function($app){
            return new ProductosRepository(DB::connection());
        });

        $this->app->scoped(IProductosService::class,function($app){
            return new ProductoService($app[IProductosRepository::class],
            $app[ProductoMapper::class],
            $app[CategoriaMapper::class],
            $app[IProveedorRepository::class],
            $app[ProveedorProductoMapper::class],
            $app[ICostosService::class],
            $app[ICostosRepository::class],
            $app[IEquivalenciasService::class]
            ,$app[IProductoOrganizacion::class]
            ,$app[IListaPreciosProductoService::class]
            );
        });

        $this->app->scoped(IOrganizacionWrapper::class,function($app){
            return new OrganizacionWrapper();
        });

        $this->app->scoped(ProductoOrganizacionMapper::class,function($app){
            return new ProductoOrganizacionMapper();
        });

        $this->app->scoped(IProductoOrganizacionRepository::class,function($app){
            return new ProductoOrganizacionRepository(DB::connection());
        });

        $this->app->scoped(IProductoOrganizacion::class,function($app){
            return new ProductoOrganizacion($app[IProductoOrganizacionRepository::class],
                $app[IProductosRepository::class],
                $app[ProductoOrganizacionMapper::class],
                $app[IOrganizacionWrapper::class]
            );
        });

        $this->app->scoped(ListaPreciosMapper::class,function($app){
            return new ListaPreciosMapper();
        });

        $this->app->scoped(IListaPreciosRepository::class,function($app){
            return new ListaPreciosRepository(DB::connection(),$app[ListaPreciosMapper::class]);
        });

        $this->app->scoped(IListaPreciosService::class,function($app){
            return new ListaPreciosService($app[ListaPreciosMapper::class],$app[IListaPreciosRepository::class]);
        });

        $this->app->scoped(ListaPreciosProductoMapper::class,function($app){
            return new ListaPreciosProductoMapper();
        });

        $this->app->scoped(IListaPreciosProductoRepository::class,function($app){
            return new ListaPreciosProductoRepository(DB::connection(),$app[ListaPreciosProductoMapper::class]);
        });

         $this->app->scoped(IListaPreciosProductoService::class,function($app){
             return new ListaPreciosProductoService(
                $app[IListaPreciosProductoRepository::class],
                $app[ListaPreciosProductoMapper::class],
                $app[IListaPreciosRepository::class],
                $app[IProductosRepository::class]
             );
         });
    }
}
