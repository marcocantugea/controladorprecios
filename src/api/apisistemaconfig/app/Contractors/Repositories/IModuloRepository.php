<?php

namespace App\Contractors\Repositories;

interface IModuloRepository extends IRepository {

    function getModulos();
    function getModulosByRol(string $rolPid);

}