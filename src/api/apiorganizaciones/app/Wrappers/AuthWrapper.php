<?php

namespace App\Wrappers;

use App\Contractors\Wrappers\IAuthWrapper;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AuthWrapper implements IAuthWrapper
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
