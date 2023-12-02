<?php

namespace App\Contractors\Services;

use App\DTOs\ModuloDTO;

interface IModuloService {

    function addModulo(ModuloDTO $dto);
    function updateModulo(ModuloDTO $dto);
    function deleteModulo(string $pid);
    function getModuloById(string $pid);
    function getModulosByRol(string $rolId);
    function getModulos();

}