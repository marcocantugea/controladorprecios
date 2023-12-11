<?php

namespace App\Contractors\Repositories;

use App\Contractors\Repositories\IRepository;

interface IUsuariosRepository extends IRepository{

    function getUsuario(string $user);
    function activateUsuario($id);
    function deActivateUsuario($id);
    function getUsuarios(array $searchParams,int $limit=500,int $offset=0);
    function getAcciones($pid);
    function getUserRol($pid);
    function updatePasswordUsario(string $pid,string $hash);
}
