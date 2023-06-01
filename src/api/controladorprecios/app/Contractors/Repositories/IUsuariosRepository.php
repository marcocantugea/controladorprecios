<?php

namespace  App\Contractors\Repositories;

use App\Contractors\Data\IRepository;

interface IUsuariosRepository extends IRepository{

    function getUsuario(string $user);
    function activateUsuario($id);
    function getUsuarios(array $searchParams,int $limit=500,int $offset=0);
}
