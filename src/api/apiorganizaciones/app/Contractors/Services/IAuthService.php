<?php

namespace App\Contractors\Services;

interface IAuthService {
    function AuthenticatedUser(string $user, string $password,string $token);
}