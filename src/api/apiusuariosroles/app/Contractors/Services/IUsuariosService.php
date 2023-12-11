<?php

namespace App\Contractors\Services;

use App\DTOs\UsuarioDTO;

interface IUsuariosService {

    function addUsuario(UsuarioDTO $usuario);
    function updateUsuario(UsuarioDTO $usuario);
    function activateUsuario($id);
    function deActivateUsuario($id);
    function deleteUsuario($id);
    function getUsuarios(array $searchParams,int $limit=500,int $offset=0);

}