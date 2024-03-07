<?php

namespace Routes;

use Laravel\Lumen\Routing\Router;


final class UploaderRoutes
{
    public const CONTROLLER_NAME='UploaderContoller';

    public static function setRoutes(Router $router){
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->get('api/uploader',self::CONTROLLER_NAME.'@show');
        });
        
    }
}
