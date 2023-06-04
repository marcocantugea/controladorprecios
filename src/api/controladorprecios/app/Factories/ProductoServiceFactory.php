<?php

namespace App\Factories;

use App\Mappers\CategoriaMapper;
use App\Mappers\ProductoMapper;
use App\Mappers\ProveedorProductoMapper;
use App\Repositories\ProductosRepository;
use App\Repositories\ProveedoresRepository;
use App\Services\ProductoService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class ProductoServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new ProductoService(new ProductosRepository(DB::connection()),
            new ProductoMapper(),
            new CategoriaMapper(),
            new ProveedoresRepository(DB::connection()),
            new ProveedorProductoMapper()
        );
        }
    }
}
