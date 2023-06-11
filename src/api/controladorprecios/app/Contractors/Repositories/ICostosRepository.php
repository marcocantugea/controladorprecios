<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface ICostosRepository extends IRepository{

    function getCostosByProveedor($id);
    function getIdCostoByProveedorAndProductoId(string $proveedorPublicId,string $productoPublicId);
    function existProveedorAndProduct(int $proveedorId,int $productoId);
    function existProveedorAndProductById(string $proveedorId,string $productoId);
}