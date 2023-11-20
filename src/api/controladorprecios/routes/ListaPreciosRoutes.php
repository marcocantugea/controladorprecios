<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class ListaPreciosRoutes{

    private const CONTROLLER='ListaPreciosController';

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/listaprecios',self::CONTROLLER.'@addListaPrecio');            
            $router->put('api/listaprecios/{pid}',self::CONTROLLER.'@updateListaPrecio');
            $router->delete('api/listaprecios/{pid}',self::CONTROLLER.'@deleteListaPrecios');
            $router->get('api/listaprecios/{pid}',self::CONTROLLER.'@getListaPrecios');
            $router->get('api/listaprecios',self::CONTROLLER.'@getListasPrecios');
            $router->post('api/listaprecios/producto',self::CONTROLLER.'@addProductoListaPrecios');
            $router->get('api/listaprecios/{listaPId}/productos',self::CONTROLLER.'@getProductosPorListaPrecio');
            $router->post('api/listaprecios/productos',self::CONTROLLER.'@addProductosListaPrecios');
            $router->get('api/listaprecios/{pid}/producto/{productoPid}',self::CONTROLLER.'@getProductoPrecio');
            $router->get('api/listaprecios/producto/{productoPId}',self::CONTROLLER.'@getProductoPrecios');
        });
    }    
}