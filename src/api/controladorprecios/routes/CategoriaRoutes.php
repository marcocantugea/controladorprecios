<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class CategoriaRoutes
{

    public static function setRoutes(Router $router){
        $router->post("api/categoria",'CategoriaController@addCategoria');
        $router->put("api/categoria/{id}",'CategoriaController@updateCategoria');
        $router->get("api/categoria/{id}",'CategoriaController@getCategoria');
        $router->delete("api/categoria/{id}",'CategoriaController@deleteCategoria');
        $router->get("api/categorias",'CategoriaController@getCategorias');
    }
    
}
