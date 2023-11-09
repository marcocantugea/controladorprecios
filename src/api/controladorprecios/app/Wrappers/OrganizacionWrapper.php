<?php

namespace App\Wrappers;

use App\Contractors\Wrappers\IOrganizacionWrapper;
use Illuminate\Support\Facades\Http;
use Exception;
use stdClass;

final class OrganizacionWrapper implements IOrganizacionWrapper
{
    private string $host;
    private string $apiVersion;
    private const API_NAME="organizacion";
    private string $apiPath="";
    private string $token;
    
    public function __construct(string $token="") {
        $this->host= (!empty($_ENV['ORGANIZACION_API_HOST'])) ? $_ENV['ORGANIZACION_API_HOST'] : getenv('ORGANIZACION_API_HOST');
        $this->apiVersion=(!empty($_ENV['ORGANIZACION_API_VERSION'])) ? $_ENV['ORGANIZACION_API_VERSION'] : getenv('ORGANIZACION_API_VERSION');
        if(empty($this->host)) throw new Exception('invalid microservce for organizacion');
        $this->apiPath= $this->host.$this->apiVersion.$this::API_NAME."/";
        $this->token= (!empty($token)) ? $token : $_SESSION['token'];
    }

    public function getOrganizacion(string $pid) : stdClass{
        $this->validateToken();
        $response= Http::withHeaders([
            'Authorization'=> 'Basic '.$this->token
        ])->get($this->apiPath.$pid)->body();
        $jsonDecode=json_decode($response);
        return $jsonDecode->data;
    }

    public function validateToken(){
        if(empty($this->token)) throw new Exception('invalid user for microservice');
    }
}
