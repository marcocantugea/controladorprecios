<?php

namespace App\Services;

use App\Factories\ProductoServiceFactory;
use App\Mappers\ProductoMapper;
use App\Repositories\ProductosRepository;
use Illuminate\Support\Facades\DB;

class ServicesContainer 
{
    private $serviceContainer;
    
    public function __construct() {
        $this->serviceContainer=[
            ProductosRepository::class=>new ProductosRepository(DB::connection()),
            ProductoMapper::class=> new ProductoMapper(),
            ProductoService::class=> ProductoServiceFactory::get()
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
