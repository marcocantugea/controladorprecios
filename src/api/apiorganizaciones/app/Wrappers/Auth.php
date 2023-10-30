<?php

namespace App\Wrappers;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Auth
{
    public function AuthenticatedUser($user,$password){

        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $response= Http::post( $apiPath.'api/auth',['user'=>$user,'password'=>$password])->throw()->json();
        
        return $response;

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $apiPath.'api/auth',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        //     CURLOPT_POSTFIELDS => '{"user":"'.$user.'","password":"'.$password.'"}',
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json'
        //     ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // echo $response;
    }

    private function getAPIPath(){
        $apiHost= (!empty($_ENV['APP_AUTHUSER_HOST'])) ? $_ENV['APP_AUTHUSER_HOST'] : getenv('APP_AUTHUSER_HOST');
        $apiVersion=(!empty($_ENV['APP_AUTHUSER_APIVERSION'])) ? $_ENV['APP_AUTHUSER_APIVERSION'] : getenv('APP_AUTHUSER_APIVERSION');

        return $apiHost.$apiVersion;
    }
    
}
