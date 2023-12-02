<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\MenusRoutes;
use Routes\ModulosRoutes;

ModulosRoutes::setRoutes($router);
MenusRoutes::setRoutes($router);