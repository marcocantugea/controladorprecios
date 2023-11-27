<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class AccionesRoutes {

    private const CONTROLLER_NAME='AccionesController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('api/accion/{pid}',self::CONTROLLER_NAME.'@getAccion');
            $router->get('api/acciones',self::CONTROLLER_NAME.'@getAcciones');
        });

    }
}