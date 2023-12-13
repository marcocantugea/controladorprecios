<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class RolUsuarioRoutes {

    private const CONTROLLER_NAME='RolUsuarioController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/rol/usuario',self::CONTROLLER_NAME.'@addRolUsuario');
            $router->delete('api/rol/usuario/relacion/{pid}',self::CONTROLLER_NAME.'@deleteRolUsuario');
            $router->get('api/rol/usuario/relacion/{pid}',self::CONTROLLER_NAME.'@getRolUsuario');
            $router->get('api/rol/usuario/{usuarioPid}/relacion',self::CONTROLLER_NAME.'@getRolByUsuarioId');
        });

    }
}