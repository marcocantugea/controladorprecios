<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class CategoriaRoutes
{

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post("api/categoria",'CategoriaController@addCategoria');
            $router->put("api/categoria/{id}",'CategoriaController@updateCategoria');
            $router->get("api/categoria/{id}",'CategoriaController@getCategoria');
            $router->delete("api/categoria/{id}",'CategoriaController@deleteCategoria');
            $router->get("api/categorias",'CategoriaController@getCategorias');
            $router->post("api/categoria/{id}/subcategoria",'CategoriaController@addSubCategoria');
            $router->post("api/categoria/{id}/subcategorias",'CategoriaController@addSubCategorias');
            $router->get("api/categoria/{id}/subcategorias",'CategoriaController@getSubCategorias');
            $router->delete("api/categoria/subcategoria/{id}",'CategoriaController@deleteCategoria');
            $router->put("api/categoria/subcategoria/{id}",'CategoriaController@updateCategoria');
        });
    }
    
}
