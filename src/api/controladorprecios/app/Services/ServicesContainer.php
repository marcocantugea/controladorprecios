<?php

namespace App\Services;

use App\Contractors\Models\Equivalencia;
use App\Factories\CategoriaServiceFactory;
use App\Factories\ProductoServiceFactory;
use App\Factories\AtibutosServiceFactory;
use App\Factories\CostosServiceFactory;
use App\Factories\EquivalenciasServiceFactory;
use App\Factories\MarcasServiceFactory;
use App\Factories\ProveedoresServiceFactory;
use App\Factories\UsuariosServiceFactory;
use App\Mappers\AtributoMapper;
use App\Mappers\CategoriaMapper;
use App\Mappers\CostoMapper;
use App\Mappers\EquivalenciaMapper;
use App\Mappers\MarcaMapper;
use App\Mappers\ProductoMapper;
use App\Mappers\ProveedorInfoBasicMapper;
use App\Mappers\ProveedorMapper;
use App\Mappers\ProveedorMarcaMapper;
use App\Mappers\ProveedorProductoMapper;
use App\Mappers\UsuarioMapper;
use App\Repositories\AtributosRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\CostosRepository;
use App\Repositories\EquivalenciasRepository;
use App\Repositories\MarcasRepository;
use App\Repositories\ProductosRepository;
use App\Repositories\ProveedoresRepository;
use App\Repositories\UsuariosRepository;
use Illuminate\Support\Facades\DB;

class ServicesContainer 
{
    private $serviceContainer;
    
    public function __construct() {
        $this->serviceContainer=[
            ProductosRepository::class=>new ProductosRepository(DB::connection()),
            ProductoMapper::class=> new ProductoMapper(),
            ProductoService::class=> ProductoServiceFactory::get(),
            CategoriaRepository::class=> new CategoriaRepository(DB::connection()),
            CategoriaService::class=> CategoriaServiceFactory::get(),
            CategoriaMapper::class => new CategoriaMapper(),
            AtributoMapper::class=> new AtributoMapper(),
            AtributosRepository::class=> new AtributosRepository(DB::connection()),
            AtributosService::class=> AtibutosServiceFactory::get(),
            MarcaMapper::class=> new MarcaMapper(),
            MarcasRepository::class => new MarcasRepository(DB::connection()),
            MarcasService::class=> MarcasServiceFactory::get(),
            UsuariosRepository::class=>new UsuariosRepository(DB::connection('users')),
            UsuarioMapper::class=>new UsuarioMapper(),
            AuthService::class=> new AuthService(new UsuariosRepository(DB::connection('users')),new UsuarioMapper()),
            UsuariosService::class=>UsuariosServiceFactory::get(),
            ProveedoresReporitory::class=>new ProveedoresRepository(DB::connection()),
            ProveedorMapper::class=> new ProveedorMapper(),
            ProveedorInfoBasicMapper::class=>new ProveedorInfoBasicMapper(),
            ProveedoresService::class=>ProveedoresServiceFactory::get(),
            ProveedorMarcaMapper::class=>new ProveedorMarcaMapper(),
            ProveedorProductoMapper::class=> new ProveedorProductoMapper(),
            CostoMapper::class => new CostoMapper(),
            CostosRepository::class=> new CostosRepository(DB::connection()),
            CostosService::class=> CostosServiceFactory::get(),
            EquivalenciaMapper::class => new EquivalenciaMapper(),
            EquivalenciasRepository::class => new EquivalenciasRepository(DB::connection()),
            EquivalenciasService::class => EquivalenciasServiceFactory::get()
        ];
    }

    public function get($class){
        return $this->serviceContainer[$class];
    }

    public static function getService($class){
        $serviceContainer= new ServicesContainer();
        return $serviceContainer->get($class);
    }

}
