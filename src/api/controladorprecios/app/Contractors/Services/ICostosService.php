<?php

namespace App\Contractors\Services;

use App\DTOs\CostoDTO;

interface ICostosService {

    function addCosto(CostoDTO $costo);
    function addCostos(array $costos);
    function updateCosto(CostoDTO $costo);
    function updateCostos(array $costos);
    function deleteCosto($id);
    function getCosto($id);
    function getCostosByProveedor($proveedorId);
}