<?php

namespace App\Wrappers;

use Illuminate\Support\Facades\Http;
use App\Contractors\Wrappers\IAuth;

class Auth implements IAuth
{
    public function AuthenticatedUser($user,$password){

        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $response= Http::post( $apiPath.'api/auth',['user'=>$user,'password'=>$password])->throw()->json();
        
        return $response;
    }

    private function getAPIPath(){
        $apiHost= (!empty($_ENV['APP_AUTHUSER_HOST'])) ? $_ENV['APP_AUTHUSER_HOST'] : getenv('APP_AUTHUSER_HOST');
        $apiVersion=(!empty($_ENV['APP_AUTHUSER_APIVERSION'])) ? $_ENV['APP_AUTHUSER_APIVERSION'] : getenv('APP_AUTHUSER_APIVERSION');

        return $apiHost.$apiVersion;
    }
    
}
