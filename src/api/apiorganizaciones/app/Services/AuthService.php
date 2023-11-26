<?php

namespace App\Services;

use App\Contractors\Repositories\IUsuariosRepository;
use App\Contractors\Services\IAuthService;
use App\Contractors\Wrappers\IAuthWrapper;
use App\Wrappers\Auth;
use App\Wrappers\AuthWrapper;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthService implements IAuthService
{
    private AuthWrapper $authWrapper;

    public function __construct(IAuthWrapper $wrapper) {
        $this->authWrapper=$wrapper;
    }

    public function AuthenticatedUser(string $user, string $password,string $token)
    {
        $response= $this->authWrapper->AuthenticatedUser($user,$password);
        if($token!=$response['data']['token']) throw new Exception("Invalid token");
        $_SESSION['token']=$token;
        $_SESSION['actions']=(isset($response['data']['actions'])) ? $response['data']['actions'] : null;
    }

}
