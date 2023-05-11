<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\CategoriaRoutes;
use Routes\ProductoRoutes;

ProductoRoutes::setRoutes($router);
CategoriaRoutes::setRoutes($router);