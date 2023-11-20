<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;


final class CanalesVentaRoutes
{
    public const CONTROLLER_NAME='CanalesVentaController';

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('api/canalesventa',self::CONTROLLER_NAME.'@getCanalesVenta');
        });
        
    }
}
