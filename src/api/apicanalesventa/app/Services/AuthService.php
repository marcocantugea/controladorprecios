<?php

namespace App\Services;

use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuth;
use App\Wrappers\Auth;
use Exception;

class AuthService implements IAuthService
{
    private Auth $authWrapper;

    public function __construct(IAuth $authWrapper) {
        $this->authWrapper=$authWrapper;
    }

    public function AuthenticatedUser(string $user, string $password,string $token)
    {
        $response= $this->authWrapper->AuthenticatedUser($user,$password);
        if($token!=$response['data']['token']) throw new Exception("Invalid token");
    }

}
