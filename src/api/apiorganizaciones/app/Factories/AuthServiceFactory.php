<?php

namespace App\Factories;

use App\Mappers\UsuarioMapper;
use App\Repositories\UsuariosRepository;
use App\Services\AuthService;
use App\Services\ServicesContainer;
use Illuminate\Support\Facades\DB;

class AuthServiceFactory
{
    private ServicesContainer $serviceContainer;

    public function __construct() {
        $this->serviceContainer= new ServicesContainer();
    }

    public static function __callStatic($name, $arguments)
    {
        if($name=='get') {
            return new AuthService();
        }
    }
}
