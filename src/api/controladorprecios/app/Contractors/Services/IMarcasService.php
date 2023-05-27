<?php

namespace App\Contractors\Services;

use App\DTOs\MarcaDTO;

interface IMarcasService{
    
    function addMarca(MarcaDTO $marcaDto);
    function updateMarca(MarcaDTO $marcaDTO);
    function deleteMarca($id);
    function getMarca($id);
    function getMarcas(array $searchParams);
}