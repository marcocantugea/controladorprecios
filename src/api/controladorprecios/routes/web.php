<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('api/producto','ProductoController@addProducto');
$router->get('api/producto/{id}','ProductoController@getProducto');
$router->get('api/productos','ProductoController@getProductos');
$router->put('api/producto/{id}','ProductoController@updateProducto');
$router->delete('api/producto/{id}','ProductoController@deleteProducto');
