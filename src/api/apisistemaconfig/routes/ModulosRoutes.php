<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

final class ModulosRoutes
{
    private const CONTROLLER_NAME='ModulosController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('api/sistema/modulos',self::CONTROLLER_NAME.'@getModulos');
        });

    }
}
