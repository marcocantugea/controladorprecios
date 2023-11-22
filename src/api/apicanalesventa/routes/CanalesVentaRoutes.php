<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;


final class CanalesVentaRoutes
{
    public const CONTROLLER_NAME='CanalesVentaController';

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/canalventa',self::CONTROLLER_NAME.'@addCanalVenta');
            $router->put('api/canalventa/{pid}',self::CONTROLLER_NAME.'@updateCanalVenta');
            $router->get('api/canalesventa',self::CONTROLLER_NAME.'@getCanalesVenta');
            $router->get('api/canalventa/{pid}',self::CONTROLLER_NAME.'@getCanalVenta');
            $router->delete('api/canalventa/{pid}',self::CONTROLLER_NAME.'@deleteCanalVenta');
            $router->post('api/canalventa/{pid}/listaprecios',self::CONTROLLER_NAME.'@addListaPrecioACanal');
            $router->delete('api/canalventa/listaprecios/{pid}',self::CONTROLLER_NAME.'@deleteListaPrecioACanal');
            $router->get('api/canalventa/{pid}/listaprecios',self::CONTROLLER_NAME.'@getListaPreciosByCanal');
        });
        
    }
}
