<?php

namespace App\Contractors\Services;

use App\DTOs\ProveedorDTO;
use App\DTOs\ProveedorInfoBasicDTO;

interface IProveedoresService {
    
    function addProveedor(ProveedorDTO $proveedor);
    function addProveedorInfoBasic(ProveedorInfoBasicDTO $proveedorInfoBasic);
    function updateProveedor(ProveedorDTO $proveedor);
    function updateProveedorBasicInfo(ProveedorInfoBasicDTO $dto);
    function deleteProveedor($id);
    function deleteProveedorInfoBasic($id);
    function getProveedor($id);
    function getProveedores(array $searchParams, int $limit=500,int $offset=0,bool $showDeleted=true);
}