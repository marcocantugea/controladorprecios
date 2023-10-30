<?php

namespace App\Services;

use App\Contractors\Repositories\IUsuariosRepository;
use App\Wrappers\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class AuthService 
{
    private Auth $authWrapper;

    public function __construct() {
        $this->authWrapper=new Auth();
    }

    public function AuthenticatedUser(string $user, string $password,string $token)
    {
        $response= $this->authWrapper->AuthenticatedUser($user,$password);
        if($token!=$response['data']['token']) throw new Exception("Invalid token");
    }

}
