<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class ProductoRoutes
{

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/producto','ProductoController@addProducto');
            $router->get('api/producto/{id}','ProductoController@getProducto');
            $router->get('api/productos','ProductoController@getProductos');
            $router->put('api/producto/{id}','ProductoController@updateProducto');
            $router->delete('api/producto/{id}','ProductoController@deleteProducto');
            $router->patch('api/producto/{id}','ProductoController@updateProductoByProperty');
        });
    }
    
}
