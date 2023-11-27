<?php

namespace App\Services;

use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuthWrapper;
use Exception;

class AuthService implements IAuthService
{
    private IAuthWrapper $authWrapper;

    public function __construct(IAuthWrapper $authWrapper) {
        $this->authWrapper=$authWrapper;
    }

    public function AuthenticatedUser(string $user, string $password,string $token)
    {
        $response= $this->authWrapper->AuthenticatedUser($user,$password);
        if($token!=$response['data']['token']) throw new Exception("Invalid token");
        $_SESSION['user']=$user;
        $_SESSION['pid']=$response['data']['pid'];
        $_SESSION['token']=$token;
        $_SESSION['actions']=(isset($response['data']['actions'])) ? $response['data']['actions'] : null;
    }
}
