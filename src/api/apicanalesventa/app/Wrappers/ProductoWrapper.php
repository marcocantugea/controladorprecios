<?php

namespace App\Wrappers;

use App\Contractors\Wrappers\IProductoWrapper;
use Illuminate\Support\Facades\Http;
use Exception;

class ProductoWrapper implements IProductoWrapper
{

    private string $token;

    public function __construct(string $token="") {
        $this->token= (!empty($token)) ? $token : $_SESSION['token'];
    }

    public function validateToken(){
        if(empty($this->token)) throw new Exception('invalid user for microservice');
    }

    private function getAPIPath(){
        $apiHost= (!empty($_ENV['PRODUCTOS_API_HOST'])) ? $_ENV['PRODUCTOS_API_HOST'] : getenv('PRODUCTOS_API_HOST');
        $apiVersion=(!empty($_ENV['PRODUCTOS_API_VERSION'])) ? $_ENV['PRODUCTOS_API_VERSION'] : getenv('PRODUCTOS_API_VERSION');

        return $apiHost.$apiVersion;
    }

    public function getProductoSimple($pid)
    {
        $this->validateToken();
        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $response=  Http::withHeaders([
            'Authorization'=> 'Basic '.$this->token
        ])->get( $apiPath."producto/$pid/detail/off")->throw()->json();
        
        return $response;   
    }

    public function getProductosSimple(array $productodId)
    {
        $this->validateToken();
        $apiPath= $this->getAPIPath();
        if(empty($apiPath)) throw new \Exception("No Api Path found", 1);
        
        $items= implode(",",$productodId);

        $response=  Http::withHeaders([
            'Authorization'=> 'Basic '.$this->token
        ])->get( $apiPath."productos/detail/off?productos=$items")->throw()->json();
        
        return $response;   
    }
}
