<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class CostoRoutes 
{
    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/costo','CostoController@addCosto');
            $router->post('api/costos','CostoController@addCostos');
            $router->get('api/costo/{id}','CostoController@getCosto');
            $router->put('api/costo/{id}','CostoController@updateCosto');
            $router->put('api/costos','CostoController@updateCostos');
            $router->delete('api/costo/{id}','CostoController@deleteCosto');
            $router->delete('api/costos','CostoController@deleteCostos');
            $router->get('api/costos/proveedor/{proveedorId}','CostoController@getCostosByProveedor');
        });
    }    
}
