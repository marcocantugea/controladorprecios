<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\AtributoRoutes;
use Routes\CategoriaRoutes;
use Routes\ProductoRoutes;

ProductoRoutes::setRoutes($router);
CategoriaRoutes::setRoutes($router);
AtributoRoutes::setRoutes($router);