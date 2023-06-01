<?php

namespace App\Factories;

use App\Mappers\UsuarioMapper;
use App\Repositories\UsuariosRepository;
use App\Services\ServicesContainer;
use App\Services\UsuariosService;
use Illuminate\Support\Facades\DB;

class UsuariosServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new UsuariosService(new UsuariosRepository(DB::connection('users')),new UsuarioMapper());
        }
    }
}
