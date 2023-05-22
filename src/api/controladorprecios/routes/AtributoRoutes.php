<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class AtributoRoutes
{

    public static function setRoutes(Router $router){
        $router->post("api/atributo",'AtributoController@addAtributo');
        $router->put('api/atributo/{id}','AtributoController@updateAtributo');
        $router->delete('api/atributo/{id}','AtributoController@deleteAtributo');
        $router->get('api/atributo/{id}','AtributoController@getAtributo');
        $router->get('api/atributos','AtributoController@getAtributos');
    }
    
}
