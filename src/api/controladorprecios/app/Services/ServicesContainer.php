<?php

namespace App\Services;

use App\Factories\CategoriaServiceFactory;
use App\Factories\ProductoServiceFactory;
use App\Factories\AtibutosServiceFactory;
use App\Factories\MarcasServiceFactory;
use App\Mappers\AtributoMapper;
use App\Mappers\CategoriaMapper;
use App\Mappers\MarcaMapper;
use App\Mappers\ProductoMapper;
use App\Repositories\AtributosRepository;
use App\Repositories\CategoriaRepository;
use App\Repositories\MarcasRepository;
use App\Repositories\ProductosRepository;
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
            MarcasService::class=> MarcasServiceFactory::get()
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
