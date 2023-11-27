<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Routes\AtributoRoutes;
use Routes\AuthRoutes;
use Routes\CategoriaRoutes;
use Routes\CostoRoutes;
use Routes\EquivalenciaRoutes;
use Routes\ListaPreciosRoutes;
use Routes\MarcaRoutes;
use Routes\ProductoOrganizacionesRoutes;
use Routes\ProductoRoutes;
use Routes\ProveedorRoutes;

ProductoRoutes::setRoutes($router);
CategoriaRoutes::setRoutes($router);
AtributoRoutes::setRoutes($router);
MarcaRoutes::setRoutes($router);
AuthRoutes::setRoutes($router);
ProveedorRoutes::setRoutes($router);
CostoRoutes::setRoutes($router);
EquivalenciaRoutes::setRoutes($router);
ProductoOrganizacionesRoutes::setRoutes($router);
ListaPreciosRoutes::setRoutes($router);