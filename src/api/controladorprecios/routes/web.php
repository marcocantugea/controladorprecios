<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\AtributoRoutes;
use Routes\CategoriaRoutes;
use Routes\MarcaRoutes;
use Routes\ProductoRoutes;
use Routes\UsuarioRoutes;

ProductoRoutes::setRoutes($router);
CategoriaRoutes::setRoutes($router);
AtributoRoutes::setRoutes($router);
MarcaRoutes::setRoutes($router);
UsuarioRoutes::setRoutes($router);