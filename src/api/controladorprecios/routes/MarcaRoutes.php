<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class MarcaRoutes {

    public static function setRoutes(Router $router){
        $router->post('api/marca','MarcaController@addMarca');
        $router->put('api/marca/{id}','MarcaController@updateMarca');
        $router->delete('api/marca/{id}','MarcaController@deleteMarca');
        $router->get('api/marca/{id}','MarcaController@getMarca');
        $router->get('api/marcas','MarcaController@getMarcas');
    }
}