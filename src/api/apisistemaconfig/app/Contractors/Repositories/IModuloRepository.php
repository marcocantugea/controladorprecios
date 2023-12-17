<?php

namespace App\Contractors\Repositories;

use App\Contractors\Models\RolModulo;

interface IModuloRepository extends IRepository {

    function getModulos();
    function getModulosByRol(string $rolPid);
    function addModuloRol(RolModulo $rolmodulo);
    function deleteModuloRol(string $pid);
    function getRolModulosIds(string $rolPid);
}