<?php

namespace App\Factories;

use App\Mappers\EquivalenciaMapper;
use App\Repositories\EquivalenciasRepository;
use App\Repositories\ProductosRepository;
use App\Services\EquivalenciasService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class EquivalenciasServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new EquivalenciasService(
                new ProductosRepository(DB::connection()),
                new EquivalenciasRepository(DB::connection()),
                new EquivalenciaMapper()
            );
        }
    }
}
