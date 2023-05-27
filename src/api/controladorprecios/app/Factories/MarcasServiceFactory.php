<?php

namespace App\Factories;

use App\Mappers\MarcaMapper;
use App\Repositories\MarcasRepository;
use App\Services\MarcasService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class MarcasServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new MarcasService(new MarcasRepository(DB::connection()),new MarcaMapper());
        }
    }
}
