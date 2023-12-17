<?php

namespace App\Contractors\Services;

use App\DTOs\ModuloDTO;
use App\DTOs\RolModuloDTO;

interface IModuloService {

    function addModulo(ModuloDTO $dto);
    function updateModulo(ModuloDTO $dto);
    function deleteModulo(string $pid);
    function getModuloById(string $pid);
    function getModulosByRol(string $rolId);
    function getModulos();
    function addModuloRol(RolModuloDTO $dto);
    function deleteModuloRol(string $pid);
    function getRolModulosIds(string $rolPid);

}