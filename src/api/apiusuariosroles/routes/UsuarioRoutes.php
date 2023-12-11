<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class UsuarioRoutes {

    public static function setRoutes(Router $router){

        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/usuario','UsuarioController@addUsuario');
            $router->delete('api/usuario/{id}','UsuarioController@deleteUsuario');
            $router->get('api/usuarios','UsuarioController@getUsuarios');
            $router->put('api/usuario/activar/{id}','UsuarioController@activateUsuario');
            $router->put('api/usuario/desactivar/{id}','UsuarioController@deActivateUsuario');
        });

    }
}