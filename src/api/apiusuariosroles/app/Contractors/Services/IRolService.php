<?php

namespace App\Contractors\Services;

interface IRolService
{
    function addRole($dto);
    function updateRol($dto);
    function deleteRol($pid);
    function getRol($pid);
    function getRoles();
    function AddAccionARol($pid,$accionPid);
    function AddAccionesARol($pid,array $accionesDto);
}
