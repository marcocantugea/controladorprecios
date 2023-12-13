<?php

namespace App\Contractors\Services;

use App\DTOs\RolUsuarioDTO;

interface IRolUsuarioService{

    function addRolUsuario(RolUsuarioDTO $dto);
    function deleteRolUsuario(string $pid);
    function getRolUsuarioById(string $pid);

}