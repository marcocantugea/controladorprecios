<?php

namespace App\Contractors\Services;

use App\DTOs\ProductoOrganizacionDTO;

interface IProductoOrganizacion{

    function addOrganizacion(string $productoId,ProductoOrganizacionDTO $dto);
    function deleteOrganizacion($publicId);
    function getOrganizaciones(string $productoId);
}