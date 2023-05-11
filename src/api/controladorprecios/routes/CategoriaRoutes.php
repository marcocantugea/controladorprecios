<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class CategoriaRoutes
{

    public static function setRoutes(Router $router){
        $router->post("api/categoria",'CategoriaController@addCategoria');
    }
    
}
