<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

final class ModulosRoutes
{
    private const CONTROLLER_NAME='ModulosController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('api/sistema/modulos',self::CONTROLLER_NAME.'@getModulos');
            $router->post('api/sistema/modulo',self::CONTROLLER_NAME.'@addModulo');
            $router->put('api/sistema/modulo/{pid}',self::CONTROLLER_NAME.'@updateModulo');
            $router->delete('api/sistema/modulo/{pid}',self::CONTROLLER_NAME.'@deleteModulo');
            $router->get('api/sistema/modulo/{pid}',self::CONTROLLER_NAME.'@getModuloById');
            $router->get('api/sistema/modulos/rol/{rolPid}',self::CONTROLLER_NAME.'@getModulosByRol');
        });

    }
}
