<?php

namespace App\Contractors\Repositories;

interface IRolAccionRepository extends IRepository{

    function getAccionesPorRol($rolPid);
    function getAccionesRoles();
    function addAccionesARole(array $models);
}