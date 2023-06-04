<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class ProveedorRoutes{

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/proveedor','ProveedorController@addProveedor');
            $router->post('api/proveedor/{id}/basicInfo','ProveedorController@addProveedorBasicInfo');
            $router->put('api/proveedor/{id}','ProveedorController@updateProveedor');
            $router->put('api/proveedor/basicInfo/{id}','ProveedorController@updateProveedorInfoBasic');
            $router->delete('api/proveedor/{id}','ProveedorController@deleteProveedor');
            $router->delete('api/proveedor/basicInfo/{id}','ProveedorController@deleteProveedorBasicInfo');
            $router->get('api/proveedor/{id}','ProveedorController@getProveedor');
            $router->get('api/proveedores','ProveedorController@getProveedores');
            $router->patch('api/proveedor/{id}/marcas','ProveedorController@updatePropiedadesProveedor');
            $router->get('api/proveedor/{id}/marcas','ProveedorController@getMarcasProveedor');
            $router->delete('api/proveedor/{id}/marcas','ProveedorController@deleteProveedorMarcas');
        });
    }

}