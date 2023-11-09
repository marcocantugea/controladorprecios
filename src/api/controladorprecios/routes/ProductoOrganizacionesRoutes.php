<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class ProductoOrganizacionesRoutes 
{
    public const CONTROLLER = "ProductoOrganizacionController";
 
    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/producto/{productoId}/organizacion',self::CONTROLLER."@addOrganzacion");
            $router->delete('api/producto/organizacion/{pid}',self::CONTROLLER."@deleteOrganizacion");
            $router->get('api/producto/{productoId}/organizacion',self::CONTROLLER."@getOrganizaciones");
        });
    }
    
}
