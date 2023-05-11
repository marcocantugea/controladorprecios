<?php

namespace App\Factories;

use App\Mappers\CategoriaMapper;
use App\Mappers\ProductoMapper;
use App\Repositories\CategoriaRepository;
use App\Services\CategoriaService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class CategoriaServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new CategoriaService(new CategoriaRepository(DB::connection()),new CategoriaMapper());
        }
    }
}
