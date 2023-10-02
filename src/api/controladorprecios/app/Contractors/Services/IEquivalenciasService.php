<?php

namespace App\Contractors\Services;

use App\DTOs\EquivalenciaDTO;

interface IEquivalenciasService {

    function addEquivalencia(EquivalenciaDTO $dto);
    function deleteEquivalencia($id);
    function getEquivalencia($id);
    function addEquivalencias(array $equivalencias);
    function getEquivalenciasByProducto(string $productoId);

}