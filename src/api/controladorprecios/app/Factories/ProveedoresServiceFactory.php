<?php

namespace App\Factories;

use App\Mappers\ProveedorInfoBasicMapper;
use App\Mappers\ProveedorMapper;
use App\Repositories\ProveedoresRepository;
use App\Services\ProveedoresService;
use Illuminate\Support\Facades\DB;

class ProveedoresServiceFactory
{
    
    private function __construct() {
        
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new ProveedoresService(new ProveedoresRepository(DB::connection()),new ProveedorMapper(),new ProveedorInfoBasicMapper());
        }
    }
}
