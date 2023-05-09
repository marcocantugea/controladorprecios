<?php

namespace App\Factories;

use App\Mappers\ProductoMapper;
use App\Repositories\ProductosRepository;
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
            return new ProductoService(new ProductosRepository(DB::connection()),new ProductoMapper());
        }
    }
}
