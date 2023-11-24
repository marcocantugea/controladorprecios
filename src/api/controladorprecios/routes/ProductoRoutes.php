<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class ProductoRoutes
{
    public const CONTROLLER_NAME ='ProductoController';

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/producto',self::CONTROLLER_NAME.'@addProducto');
            $router->get('api/producto/{id}',self::CONTROLLER_NAME.'@getProducto');
            $router->get('api/productos',self::CONTROLLER_NAME.'@getProductos');
            $router->put('api/producto/{id}',self::CONTROLLER_NAME.'@updateProducto');
            $router->delete('api/producto/{id}',self::CONTROLLER_NAME.'@deleteProducto');
            $router->patch('api/producto/{id}',self::CONTROLLER_NAME.'@updateProductoByProperty');
            $router->get('api/producto/{pid}/detail/off',self::CONTROLLER_NAME.'@getProductoSimple');
            $router->get('api/productos/detail/off',self::CONTROLLER_NAME.'@getProductosSimple');
        });
    }
    
}
