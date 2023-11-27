<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class RolAccionesRoutes {

    private const CONTROLLER_NAME='RolAccionesController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/rol/accion',self::CONTROLLER_NAME.'@addRolAccion');
            $router->get('api/rol/accion/{pid}',self::CONTROLLER_NAME.'@getRolAccion');
            $router->delete('api/rol/accion/{pid}',self::CONTROLLER_NAME.'@deleteRolAccion');
            $router->get('api/roles/acciones',self::CONTROLLER_NAME.'@getAccionesRoles');
            $router->get('api/roles/{rolPid}/acciones',self::CONTROLLER_NAME.'@getAccionesPorRol');
            $router->post('api/roles/acciones',self::CONTROLLER_NAME.'@addAccionesARol');
        });

    }
}