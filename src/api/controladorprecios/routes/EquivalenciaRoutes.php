<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class EquivalenciaRoutes{

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/producto/equivalencia','EquivalenciaController@addEquivalencia');
            $router->delete('api/producto/equivalencia/{publicId}','EquivalenciaController@deleteEquivalencia');
        });
    }    
}