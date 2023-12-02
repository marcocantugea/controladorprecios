<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

final class MenusRoutes 
{
    private const CONTROLLER_NAME='MenuController';

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/sistema/menu',self::CONTROLLER_NAME.'@addMenu');
            $router->get('api/sistema/menus',self::CONTROLLER_NAME.'@getMenus');
            $router->get('api/sistema/menu/{pid}',self::CONTROLLER_NAME.'@getMenuById');
            $router->put('api/sistema/menu/{pid}',self::CONTROLLER_NAME.'@updateMenu');
            $router->delete('api/sistema/menu/{pid}',self::CONTROLLER_NAME.'@deleteMenu');
            $router->get('api/sistema/modulo/{moduloPid}/menus',self::CONTROLLER_NAME.'@getMenusByModulo');
            $router->get('api/sistema/modulo/menus/usuario',self::CONTROLLER_NAME.'@getModulosYMenusPorUsuario');
        });

    }
}
