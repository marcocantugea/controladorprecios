<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;

class OrganizacionRoutes
{
    public const CONTROLLERNAME ='OrganizacionController' ;

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('api/organizacion',self::CONTROLLERNAME.'@addOrganizacion');
            $router->get('api/organizacion/{publicId}',self::CONTROLLERNAME.'@getOrganizacion');
            $router->delete('api/organizacion/{publicId}',self::CONTROLLERNAME.'@deleteOrganizacion');
        });
        
    }
    
}
