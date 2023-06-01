<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class AuthRoutes {

    public static function setRoutes(Router $router){
        $router->get('api/auth','AuthController@AuthUsuario');
    }

}