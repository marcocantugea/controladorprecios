<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\AtributoRoutes;
use Routes\AuthRoutes;
use Routes\CategoriaRoutes;
use Routes\MarcaRoutes;
use Routes\ProductoRoutes;
use Routes\ProveedorRoutes;
use Routes\UsuarioRoutes;

ProductoRoutes::setRoutes($router);
CategoriaRoutes::setRoutes($router);
AtributoRoutes::setRoutes($router);
MarcaRoutes::setRoutes($router);
UsuarioRoutes::setRoutes($router);
AuthRoutes::setRoutes($router);
ProveedorRoutes::setRoutes($router);