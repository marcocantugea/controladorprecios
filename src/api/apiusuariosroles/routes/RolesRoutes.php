<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class RolesRoutes {

    private const CONTROLLER_NAME='RolesController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/rol',self::CONTROLLER_NAME.'@addRol');
            $router->put('api/rol/{pid}',self::CONTROLLER_NAME.'@updateRol');
            $router->delete('api/rol/{pid}',self::CONTROLLER_NAME.'@deleteRol');
            $router->get('api/rol/{pid}',self::CONTROLLER_NAME.'@getRol');
            $router->get('api/roles',self::CONTROLLER_NAME.'@getRoles');
        });

    }
}