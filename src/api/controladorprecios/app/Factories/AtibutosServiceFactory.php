<?php

namespace App\Factories;

use App\Mappers\AtributoMapper;
use App\Repositories\AtributosRepository;
use App\Services\AtributosService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class AtibutosServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new AtributosService(new AtributosRepository(DB::connection()),new AtributoMapper());
        }
    }
}
