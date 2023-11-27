<?php

namespace App\Contractors\Services;

use App\DTOs\RolAccionDTO;

interface IRolAccionService{

    function addRolAccion(RolAccionDTO $dto);
    function deleteRolAccion(string $pid);
    function getRolAccion(string $pid);
    function getAccionesPorRol(string $rolPid);
    function getAccionesRoles();
    function addAccionesARol(array $dtos);
}