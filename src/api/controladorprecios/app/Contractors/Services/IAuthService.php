<?php

namespace App\Contractors\Services;

use App\DTOs\UsuarioDTO;

interface IAuthService{

   /**
     * Authenticated User with given token
     * @param string $user
     * @param string $password
     * @param string $token
     * @return void
     */
    function AuthenticatedUser(string $user, string $password,string $token);
}