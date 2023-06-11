<?php

namespace App\Factories;

use App\Mappers\CostoMapper;
use App\Mappers\MarcaMapper;
use App\Repositories\CostosRepository;
use App\Repositories\MarcasRepository;
use App\Repositories\ProductosRepository;
use App\Repositories\ProveedoresRepository;
use App\Services\CostosService;
use App\Services\MarcasService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class CostosServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new CostosService(new CostosRepository(DB::connection())
            ,new CostoMapper()
            ,new ProveedoresRepository(DB::connection())
            ,new ProductosRepository(DB::connection())
        );
        }
    }
}
