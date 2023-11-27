<?php

namespace App\Contractors\Services;

use App\DTOs\UsuarioDTO;

interface IAuthService{

    function AuthenticatedUser(string $user, string $password);
    function AddUser(UsuarioDTO $usuario);
    function updateUserPassword(UsuarioDTO $usuario);
    function activateUser($id);
}