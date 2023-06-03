<?php

namespace App\Contractors\Repositories;

use App\Contractors\Data\IRepository;
use App\Contractors\Models\ProveedorInfoBasic;
use App\Contractors\Models\ProveedorMarca;
use App\Contractors\Models\ProveedorProducto;

interface IProveedorRepository extends IRepository{
    
    function addProveedorInfoBasic(ProveedorInfoBasic $model);
    function updateProveedorInfoBasic(ProveedorInfoBasic $model);
    function deleteProveedorInfoBasic($id);
    function getProveedorInfoBasic($id);
    function getInfoBasicByProveedor(string $idProveedor);
    function addProveedorMarca(ProveedorMarca $model);
    function addProveedorProducto(ProveedorProducto $model);
    function getProveedores(array $searchParams,int $limit=500,int $offset=0,bool $showDeleted=true);
    function getProveedorByCode(string $code);
}